<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Actions\CalculerSalaireMensuel;
use App\Filament\Resources\EmployeeResource;
use App\Models\Annee;
use App\Models\Contrat;
use App\Models\Employee;
use App\Models\ModePaiement;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use App\Models\TypePaiement;
use App\Services\ItsService;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Exception;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $modelLabel = 'Employé';

    protected static ?string $pluralModelLabel = 'Employés';

    protected static ?string $label = 'Employés';

    protected static ?string $title = 'Employés';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Fieldset::make('A propos du contrat')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->optionsLimit(5)
                            ->relationship('category', 'nom')
                            ->default(null),
                        Forms\Components\Select::make('fonction_id')
                            ->label('Fonction')
                            ->relationship(name: 'fonction', titleAttribute: 'nom')
                            ->searchable()
                            ->required()
                            ->columnSpan(1)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nom')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\Select::make('position_hierachique_id')
                            ->label('Position Hiérachique')
                            ->relationship(name: 'positionHierachique', titleAttribute: 'nom')
                            ->searchable()
                            ->columnSpan(1)
                            ->optionsLimit(5)
                            ->preload(),
                        ToggleButtons::make('est_cadre')
                            ->label('Est il cadre ?')
                            ->options([
                                '1' => 'Oui',
                                '0' => 'Non',
                            ])
                            ->colors([
                                '1' => 'accent',
                                '0' => 'error',
                            ])
                            ->default('0')
                            ->grouped()
                            ->inline(),
                        Forms\Components\DatePicker::make('date_debut')
                            ->label('Date d\'embauche')
                            ->required()
                            ->date(),
                        Forms\Components\DatePicker::make('date_fin')
                            ->label('Date de fin de contrat')
                            ->required()
                            ->date()
                            ->after('date_debut'),
                        Forms\Components\TextInput::make('salaire_brut')
                            ->label('Salaire brut')
                            ->required()
                            ->columnSpan(2)
                            ->live()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->suffix('FCFA')
                            ->numeric()
                            ->afterStateUpdated(fn (Forms\Set $set, $state) => $set('tauxIts', ItsService::getIts(intval($state))))
                            ->default(0),
                        Forms\Components\Select::make('statut')
                            ->label('Statut')
                            ->options([
                                'En cours' => 'En cours',
                                'Clos' => 'Clos',
                            ])
                            ->default('En cours'),
                        Forms\Components\TextInput::make('nb_jours_conges_acquis')
                            ->numeric()
                            ->columnSpan(2)
                            ->label('Nombre de jours de congés acquis')
                            ->default(0),
                        Forms\Components\TextInput::make('solde_jours_conges_payes')
                            ->numeric()
                            ->label('Coût unitaire')
                            ->default(0),
                        Forms\Components\TextInput::make('tauxIts')
                            ->hidden()
                            ->numeric()
                            ->label('Taux ITS')
                            ->suffix('%')
                            ->default(0),

                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make(label: 'Informations personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('npi')
                            ->label('Numero d\' idendentification personnelle (NPI)')
                            ->maxLength(10)
                            ->numeric()
                            ->hidden()
                            ->default(null),
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->autocapitalize(),
                        Forms\Components\TextInput::make('prenoms')
                            ->label('Prénoms')
                            ->required()
                            ->maxLength(15),
                        PhoneInput::make('telephone')
//                                    ->prefix('+229')
                            ->label('Téléphone')
                            ->hint('Contact téléphonique')
                            ->required()
                            ->unique(table: 'employees', column: 'telephone')
//                            ->prefix('+229')
//                            ->maxLength(8)
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(table: 'employees', column: 'email')
                            ->required()
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('ifu')
                            ->numeric()
                            ->placeholder('Ex: 1234567890123')
                            ->label('Identifiant fiscal unique (IFU)')
                            ->maxLength(16)
                            ->default(null),
                        Forms\Components\DatePicker::make('date_naissance')
                            ->date()
                            ->label('Date de naissance')
                            ->maxDate(now()->subYears(18)),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->maxLength(20)
                            ->label('Lieu de naissance')
                            ->default(null),
                        Forms\Components\Select::make('situation_matrimoniale')
                            ->label('Situation matrimoniale')
                            ->options([
                                'Célibataire' => 'Célibataire',
                                'Mariée' => 'Mariée',
                                'Divorcée' => 'Divorcée',
                                'Veuf' => 'Veuf/Veuve',
                            ])
                            ->default(null),
                        Forms\Components\Select::make('sexe')
                            ->label('Sexe')
                            ->options([
                                'M' => 'Masculin',
                                'F' => 'Féminin',
                                'I' => 'Autre',
                            ])
                            ->default(null),
                        Forms\Components\TextInput::make('nb_enfants')
                            ->label("Nombre d'enfants")
                            ->integer()
                            ->default(0),
                    ]),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee.nom')
            ->columns([
                Tables\Columns\TextColumn::make('employee.nom')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.prenoms')
                    ->label('Prénoms')
                    ->searchable(),
                PhoneColumn::make('employee.telephone')
                    ->label('Téléphone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.nom')
                    ->label('Catégorie')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('est_cadre')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Cadre')
                    ->boolean(),
                Tables\Columns\TextColumn::make('salaire_brut')
                    ->label('Salaire brut')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->label('Date d\'embauche')
                    ->dateTime(format: ' l d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->label('Date de fin de contrat')
                    ->dateTime(format: ' l F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Employés'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Ajouter un employé')
                    ->mutateFormDataUsing(function (array $data) {
                        $annee = Annee::latest()->first();
                        $data['annee_id'] = getAnnee()->id;
                        $dataForEmployee = [];
                        //                        $dataForEmployee['npi'] = $data['npi'];
                        $dataForEmployee['annee_id'] = $data['annee_id'];
                        $dataForEmployee['nom'] = $data['nom'];
                        $dataForEmployee['prenoms'] = $data['prenoms'];
                        $dataForEmployee['telephone'] = $data['telephone'];
                        $dataForEmployee['email'] = $data['email'];
                        $dataForEmployee['date_naissance'] = $data['date_naissance'];
                        $dataForEmployee['lieu_naissance'] = $data['lieu_naissance'];
                        $dataForEmployee['situation_matrimoniale'] = $data['situation_matrimoniale'];
                        $dataForEmployee['sexe'] = $data['sexe'];
                        $dataForEmployee['nb_enfants'] = $data['nb_enfants'];

                        $employee = Employee::create($dataForEmployee);
                        $data['employee_id'] = $employee->id;
                        $data['date_signature'] = now();

                        //                        $filterData = [];
                        //                        $filterData['client_id'] = $data['client_id'];
                        //                        $filterData['employee_id'] = $data['employee_id'];
                        //                        $filterData['date_signature'] = $data['date_signature'];
                        //                        $filterData['date_debut'] = $data['date_debut'];
                        //                        $filterData['date_fin'] = $data['date_fin'];
                        //                        $filterData['salaire_brut'] = $data['salaire_brut'];
                        //                        $filterData['nb_jours_conges_acquis'] = $data['nb_jours_conges_acquis'];
                        //                        $filterData['solde_jours_conges_payes'] = $data['solde_jours_conges_payes'];
                        //                        $filterData['tauxIts'] = ItsService::getIts(intval($data['salaire_brut']));
                        //                        $filterData['est_cadre'] = $data['est_cadre'];
                        //                        $filterData['category_id'] = $data['category_id'];
                        //                        $filterData['fonction_id'] = $data['fonction_id'];
                        //                        $filterData['statut'] = $data['statut'];

                        return $data;
                    }),
                Tables\Actions\AttachAction::make()
                    ->modalHeading('Ajouter un contrat')
                    ->form([
                        Forms\Components\Section::make('')
                            ->schema([
                                Forms\Components\Select::make('employee_id')
                                    ->label('Employé')
                                    ->relationship('employee', 'nom')
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nom} {$record->prenoms}")
                                    ->required()
                                    ->columnSpanFull()
                                    ->optionsLimit(5)
                                    ->preload(),
                                Forms\Components\Select::make('category_id')
                                    ->label('Catégorie')
                                    ->relationship('category', 'nom')
                                    ->searchable()
                                    ->columnSpan(2)
                                    ->required()
                                    ->optionsLimit(5)
                                    ->preload(),
                                Forms\Components\Select::make('fonction_id')
                                    ->label('Fonction')
                                    ->relationship(name: 'fonction', titleAttribute: 'nom')
                                    ->searchable()
                                    ->columnSpan(2)
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nom')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->optionsLimit(5)
                                    ->preload(),
                                Forms\Components\Select::make('position_hierachique_id')
                                    ->label('Position Hiérachique')
                                    ->relationship(name: 'positionHierachique', titleAttribute: 'nom')
                                    ->searchable()
                                    ->columnSpan(2)
                                    ->optionsLimit(5)
                                    ->preload(),
                                ToggleButtons::make('est_cadre')
                                    ->label('Est il cadre ?')
                                    ->options([
                                        '1' => 'Oui',
                                        '0' => 'Non',
                                    ])
                                    ->colors([
                                        '1' => 'accent',
                                        '0' => 'error',
                                    ])
                                    ->default('0')
                                    ->grouped()
                                    ->inline(),
                                Forms\Components\DatePicker::make('date_debut')
                                    ->label('Date de début de contrat')
                                    ->required()
                                    ->columnSpan(3)
                                    ->date(),
                                Forms\Components\DatePicker::make('date_fin')
                                    ->label('Date de fin de contrat')
                                    ->required()
                                    ->columnSpan(2)
                                    ->date()
                                    ->after('date_debut'),
                                Forms\Components\TextInput::make('salaire_brut')
                                    ->label('Salaire brut')
                                    ->required()
                                    ->columnSpan(3)
                                    ->live()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('FCFA')
                                    ->numeric()
                                    ->afterStateUpdated(fn (Forms\Set $set, $state) => $set('tauxIts', ItsService::getIts(intval($state)))
                                    )
                                    ->default(0),
                                Forms\Components\Select::make('statut')
                                    ->label('Statut')
                                    ->columnSpan(3)
                                    ->options([
                                        'En cours' => 'En cours',
                                        'Clos' => 'Clos',
                                    ])
                                    ->default('En cours'),
                                Forms\Components\TextInput::make('nb_jours_conges_acquis')
                                    ->numeric()
                                    ->columnSpan(3)
                                    ->label('Nombre de jours de congés acquis')
                                    ->default(0),
                                Forms\Components\TextInput::make('solde_jours_conges_payes')
                                    ->numeric()
                                    ->label('Coût unitaire')
                                    ->columnSpan(3)
                                    ->default(0),

                            ])
                            ->columns(6),
                    ])
                    ->label('Ajouter un contrat à un employé existant')
                    ->action(function (array $data) {
                        $data['client_id'] = self::getOwnerRecord()->id;
                        $employee = Employee::find($data['employee_id']);
                        $data['annee_id'] = getAnnee()->id;
                        $data['date_signature'] = now();
                        $data['tauxIts'] = ItsService::getIts(intval($data['salaire_brut']));
                        $employee->contrats()->create($data);
                    })
                    ->attachAnother(false)
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Contrat ajouté avec succès')
                    )
                    ->modalWidth('4xl'),
            ])
            ->actions([
                Tables\Actions\Action::make('payer')
                    ->icon('heroicon-o-banknotes')
                    ->color('tertiary')
                    ->form([
                        Forms\Components\Section::make('Paiements')
                            ->schema([
                                Forms\Components\Select::make('type_paiement_id')
                                    ->label('Type de paiement')
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->preload()
                                    ->options(TypePaiement::query()->where('nom', '!=', 'Salaire')->pluck('nom', 'id'))
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nom')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->optionsLimit(3),
                                Forms\Components\TextInput::make('solde')
                                    ->label('Montant')
                                    ->required()
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->hidden(fn (Forms\Get $get) => $get('type_paiement_id') == TypePaiement::SALAIRE)
                                    ->maxValue(function (Contrat $record, Forms\Get $get) {
                                        if ($get('type_paiement_id') == TypePaiement::AVANCE) {
                                            return $record->salaire_brut / 2;
                                        }
                                    })
                                    ->default(5000)
                                    ->suffix('FCFA'),
                                Forms\Components\Select::make('mode_paiement_id')
                                    ->label('Mode de paiement')
                                    ->searchable()
                                    ->options(ModePaiement::query()->pluck('nom', 'id'))
                                    ->preload()
                                    ->columnSpan(function (Forms\Get $get) {
                                        return $get('type_paiement_id') == TypePaiement::SALAIRE ? 2 : 1;
                                    })
                                    ->optionsLimit(3)
                                    ->required(),
                                Forms\Components\DateTimePicker::make('date_debut')
                                    ->helperText('Intervalle du service payé')
                                    ->hidden()
                                    ->columnSpan(2)
                                    ->label('Date de début'),
                                Forms\Components\DateTimePicker::make('date_fin')
                                    ->helperText('Intervalle du service payé')
                                    ->hidden()
                                    ->columnSpan(2)
                                    ->label('Date de fin'),
                                Forms\Components\TextInput::make('nb_jours_travaille')
                                    ->numeric()
                                    ->disabled()
                                    ->label('Nombre de jours travaillés')
                                    ->default(function (Contrat $record) {
                                        return CalculerSalaireMensuel::nbreJoursTravaille($record);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('pas')
                                    ->label('Echelon')
                                    ->visible(fn (Forms\Get $get) => $get('type_paiement_id') == TypePaiement::PRET)
                                    ->columnSpan(2)
                                    ->helperText('Echelonner le paiement')
                                    ->numeric(),

                            ])->columns(2),
                        //                        $this->getContentSection(),

                    ])
                    ->action(function (array $data, Contrat $record) {
                        try {
                            Notification::make('paiement operer')
                                ->title('Paiement opéré')
                                ->body('Paiement opéré. Cependant, veuillez vérifier le statut(payé) du paiement')
                                ->success()
                                ->iconColor('tertiary')
                                ->icon('heroicon-o-banknotes')
                                ->send();
                        } catch (Exception $e) {
                            Notification::make('paiement non operer')
                                ->title('Paiement non opéré')
                                ->body('Paiement non opéré. Veuillez réessayer')
                                ->danger()
                                ->iconColor('tertiary')
                                ->icon('heroicon-o-banknotes')
                                ->send();

                        }
                        $record->paiements()->create($data);
                    })
                    ->label('Effectuer un paiement'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ])->tooltip('Actions disponibles'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('salaire')
                        ->color('tertiary')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('mode_paiement_id')
                                ->searchable()
                                ->label('Mode de paiement')
                                ->live(onBlur: true)
                                ->options(ModePaiement::query()->pluck('nom', 'id'))
                                ->preload(),
                            Forms\Components\Select::make('type_paiement_id')
                                ->searchable()
                                ->live(onBlur: true)
                                ->hidden()
                                ->preload()
                                ->default(TypePaiement::SALAIRE)
                                ->options(TypePaiement::query()->where('nom', '!=', 'Salaire')->pluck('nom', 'id'))
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('nom')
                                        ->required()
                                        ->maxLength(255),
                                ])
                                ->optionsLimit(3),
                        ])
                        ->icon('heroicon-o-banknotes')
                        ->action(function (array $data, $records) {
                            $donnes = [SoldeCompte::SALAIRE_MENSUEL, SoldeCompte::TREIZIEME_MOIS, SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU, SoldeCompte::PREAVIS, SoldeCompte::AVANCE_SUR_SALAIRE, SoldeCompte::PRET_ENTREPRISE, SoldeCompte::TOTAL];

                            foreach ($records as $record) {
                                $salaire_mensuel = (new CalculerSalaireMensuel())->handle($record);
                                $startDate = new DateTime($record->demandeConges()->where('statut', 'paye')->first()?->date_debut);
                                $endDate = new DateTime($record->demandeConges()->where('statut', 'paye')->first()?->date_fin);
                                $montantJoursCongesPaye = date_diff($startDate, $endDate)->days * $record->solde_jours_conges_payes;
                                $montantAvanceSalaire = $record->paiements()->where('type_paiement_id', TypePaiement::AVANCE)->sum('solde');
                                $prets = CalculerSalaireMensuel::sommePrets($record);
                                $total = $salaire_mensuel + $montantJoursCongesPaye - $montantAvanceSalaire - $prets;
                                //                                dd('salaire mensuel: ' . $salaire_mensuel, 'montant jours de congés payés: ' . $montantJoursCongesPaye, 'montant avance salaire: ' . $montantAvanceSalaire, 'prets: ' . $prets, 'total: ' . ($salaire_mensuel + $montantJoursCongesPaye - $montantAvanceSalaire - $prets)  );
                                Paiement::updateOrCreate([
                                    'contrat_id' => $record->id,
                                ], [
                                    'date_paiement' => now(),
                                    'contrat_id' => $record->id,
                                    'statut' => 'effectue',
                                    'solde' => $total,
                                    'mode_paiement_id' => $data['mode_paiement_id'],
                                    'type_paiement_id' => TypePaiement::SALAIRE,
                                ]);
                                foreach ($donnes as $donne) {
                                    $record->soldeComptes()->updateOrCreate([
                                        'mois' => now()->format('F'),
                                        'contrat_id' => $record->id,
                                        'donnees' => $donne,
                                    ],
                                        [
                                            'mois' => now()->format('F'),
                                            'donnees' => $donne,
                                            'montant' => match ($donne) {
                                                SoldeCompte::SALAIRE_MENSUEL => $salaire_mensuel,
                                                SoldeCompte::TREIZIEME_MOIS => 0,
                                                SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU => $montantJoursCongesPaye,
                                                SoldeCompte::PREAVIS => 0,
                                                SoldeCompte::AVANCE_SUR_SALAIRE => $montantAvanceSalaire,
                                                SoldeCompte::PRET_ENTREPRISE => $prets,
                                                SoldeCompte::TOTAL => $total,
                                            },
                                        ]);
                                }
                            }
                            Notification::make('salaires payes')
                                ->title('Paiement des salaires effectué')
                                ->body('Paiement des salaires effectué. Veuillez vérifier les paiements effectués dans la liste des paiements')
                                ->color('tertiary')
                                ->iconColor('tertiary')
                                ->icon('heroicon-o-banknotes')
                                ->send();
                            redirect(EmployeeResource::getUrl('salaires-paiements', ['records' => $records->pluck('id')->implode(',')]));
                        })
//                        ->url(fn($records) => EmployeeResource::getUrl('salaires-paiements', ['records' => $records]))
//                        ->requiresConfirmation()
                        ->label('Payer Salaire'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename('Liste des employés'),
                    ]),
            ]);
    }
}

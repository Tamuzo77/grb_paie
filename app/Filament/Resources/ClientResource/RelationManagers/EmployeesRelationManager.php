<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Actions\CalculerSalaireMensuel;
use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\ModePaiement;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use App\Models\TypePaiement;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use PHPUnit\Exception;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $modelLabel = 'Employé';

    protected static ?string $title = 'Employés';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Entreprise d\'appartenance')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(5)
                            ->relationship('category', 'nom')
                            ->default(null),
                        Forms\Components\Select::make('fonctions')
                            ->label('Fonctions')
                            ->relationship(titleAttribute: 'nom')
                            ->multiple()
                            ->searchable()
                            ->columnSpan(2)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nom')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->optionsLimit(5)
                            ->preload(),
                        ToggleButtons::make('cadre')
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
                        Forms\Components\DatePicker::make('date_embauche')
                            ->date(),
                        Forms\Components\DatePicker::make('date_depart')
                            ->date()
                            ->after('date_embauche'),

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
                            ->columnSpan(2)
                            ->autocapitalize(true),
                        Forms\Components\TextInput::make('prenoms')
                            ->label('Prénoms')
                            ->required()
                            ->maxLength(15),
                        PhoneInput::make('telephone')
//                                    ->prefix('+229')
                            ->label('Téléphone')
                            ->hint('Contact téléphonique')
                            ->required()
                            ->unique(ignoreRecord : true)
//                            ->prefix('+229')
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\DatePicker::make('date_naissance')
                            ->label('Date de naissance')
                            ->date()
                            ->maxDate(now()->subYears(18)),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->label('Lieu de naissance')
                            ->maxLength(20)
                            ->default(null),
                        Forms\Components\Select::make('situation_matrimoniale')
                            ->options([
                                'Célibataire' => 'Célibataire',
                                'Mariée' => 'Mariée',
                                'Divorcée' => 'Divorcée',
                                'Veuf' => 'Veuf/Veuve',
                            ])
                            ->default(null),
                        Forms\Components\Select::make('sexe')
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

                Forms\Components\Fieldset::make('Informations financières')
                    ->schema([
                        Forms\Components\Select::make('bank_id')
                            ->label('Banque')
                            ->live()
                            ->hintColor('accent')
                            ->relationship('bank', 'code')
                            ->hintIcon('far-building')
                            ->searchable()
                            ->required()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\TextInput::make('numero_compte')
                            ->label('Numéro de compte')
                            ->maxLength(15)
                            ->numeric()
                            ->default(null),
                        Forms\Components\TextInput::make('salaire')
                            ->label('Salaire brut')
                            ->required()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->suffix('FCFA')
                            ->numeric()
                            ->columnSpan(EmployeeResource::getPages()['edit'] ? 2 : 1)
                            ->default(0),
                        Forms\Components\TextInput::make('tauxCnss')
                            ->label('Taux CNSS')
                            ->numeric()
                            ->columnSpanFull()
                            ->hiddenOn('edit')
//                            ->inputMode('decimal')
                            ->suffix('%')
                            ->default(3.6),

                    ]),
                Forms\Components\Fieldset::make(label: 'Informations complémentaires')
                    ->schema([
                        Forms\Components\TextInput::make('nb_jours_conges_acquis')
                            ->label('Nombre de jours de congés acquis')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('solde_jours_conges_payes')
                            ->label('Coût unitaire')
                            ->numeric()
                            ->default(0),
                    ]),

            ]);
    }

    protected function getContentSection()
    {
        return Forms\Components\Section::make('solde')
            ->schema([
                Forms\Components\Grid::make(columns: 1)
                    ->schema([
                        Forms\Components\TextInput::make('salaire_mensuel')
                            ->label('Salaire mensuel')
                            ->placeholder('Salaire mensuel')
                            ->numeric()
                            ->hiddenLabel()
                            ->readOnly()
                            ->suffix('FCFA'),
                        Forms\Components\Checkbox::make('trezieme_mois')
                            ->label('Treizième mois')
                            ->default(false),
                        Forms\Components\TextInput::make('nb_jours_conges_payes')
                            ->hiddenLabel()
                            ->placeholder('Nombre de jours de congés payés')
                            ->numeric()
                            ->default(11)
                            ->maxValue(19),
                    ])->columnSpan(1),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\ViewField::make('solde_preview')
                            ->label('Solde')
                            ->columnSpanFull()
                            ->view('filament.employee.solde.preview'),
                    ])->columnSpan(2),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenoms')
                    ->label('Prénoms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.nom')
                    ->label('Catégorie')
                    ->searchable(),
                Tables\Columns\IconColumn::make('cadre')
                    ->boolean(),
                Tables\Columns\TextColumn::make('salaire')
                    ->label('Salaire brut')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
//            ->selectable(function (Employee $record) {
//                dd($record->paiements) ;
//            })
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Employés'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //                Tables\Actions\Action::make('cotisations')
                ////                    ->url(fn ($record) => static::getUrl('cotisations', ['record' => $record]))
                //                    ->icon('heroicon-o-currency-dollar')
                //                    ->color('success')
                //                    ->label('Cotisations'),
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
                                    ->live(onBlur: true)
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
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('FCFA')
                                    ->numeric()
                                    ->live()
                                    ->hidden(fn (Forms\Get $get) => $get('type_paiement_id') == TypePaiement::SALAIRE)
                                    ->maxValue(function (Employee $record, Forms\Get $get) {
                                        if ($get('type_paiement_id') == TypePaiement::AVANCE) {
                                            return $record->salaire / 2;
                                        }
                                    })
                                    ->suffix('FCFA'),
                                Forms\Components\Select::make('mode_paiement_id')
                                    ->label('Mode de paiement')
                                    ->searchable()
                                    ->options(ModePaiement::query()->pluck('nom', 'id'))
                                    ->preload()
                                    ->columnSpan(fn(Forms\Get $get) => $get('type_paiement_id') == TypePaiement::PRET ? 1 : 2)
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
                                    ->columnSpan(fn(Forms\Get $get) => $get('type_paiement_id') == TypePaiement::PRET ? 2 : 'full')
                                    ->label('Date de fin'),
                                Forms\Components\TextInput::make('nb_jours_travaille')
                                    ->numeric()
                                    ->label('Nombre de jours travaillés')
                                    ->default(function (Employee $record) {
                                        return CalculerSalaireMensuel::nbreJoursTravaille($record);
                                    })
                                    ->hidden()
                                    ->required(),
                                Forms\Components\TextInput::make('pas')
                                    ->label('Echéance')
                                    ->visible(fn (Forms\Get $get) => $get('type_paiement_id') == TypePaiement::PRET)
//                                    ->columnSpan(2)
                                    ->default(1)
                                    ->helperText('Echéance de paiement')
                                    ->numeric(),

                            ])->columns(2),
                        //                        $this->getContentSection(),

                    ])
                    ->action(function (array $data, Employee $record) {
                        try {
                            $record->paiements()->create($data);
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
                    })
                    ->label('Effectuer un paiement'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ]),

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
                                $montantAvanceSalaire = $record->paiements()->where('type_paiement_id', 1)->sum('solde');
                                $prets = CalculerSalaireMensuel::sommePrets($record);
                                Paiement::updateOrCreate([
                                    'employee_id' => $record->id,
                                ], [
                                    'date_paiement' => now(),
                                    'employee_id' => $record->id,
                                    'statut' => 'effectue',
                                    'solde' => $salaire_mensuel,
                                    'mode_paiement_id' => $data['mode_paiement_id'],
                                    'type_paiement_id' => TypePaiement::SALAIRE,
                                ]);
                                foreach ($donnes as $donne) {
                                    $record->soldeComptes()->updateOrCreate([
                                        'mois' => now()->format('F'),
                                        'employee_id' => $record->id,
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
                                                SoldeCompte::TOTAL => $salaire_mensuel + $montantJoursCongesPaye - $montantAvanceSalaire - $prets,
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
                            $this->redirect(EmployeeResource::getUrl('salaires-paiements', ['records' => $records->pluck('id')->implode(',')]));
                        })
//                        ->url(fn($records) => EmployeeResource::getUrl('salaires-paiements', ['records' => $records]))
//                        ->requiresConfirmation()
                        ->label('Payer Salaire'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}

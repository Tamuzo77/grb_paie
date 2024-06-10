<?php

namespace App\Filament\Resources;

use App\Actions\CalculerSalaireMensuel;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers\AbsencesRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\ContratsRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\DemandeCongesRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\MisAPiedsRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\PrimesRelationManager;
use App\Models\Annee;
use App\Models\Employee;
use App\Models\ModePaiement;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use App\Models\TypePaiement;
use DateTime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Exception;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $modelLabel = 'Employés';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'nom';

    protected static ?Annee $annee = null;

    public function __construct()
    {
        $annee = Annee::whereSlug($filters['annee_id'] ?? now()->year)->firstOrFail();
        self::$annee = $annee;

    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                            ->unique(table: 'employees', column: 'telephone', ignoreRecord: true)
//                            ->prefix('+229')
//                            ->maxLength(8)
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(table: 'employees', column: 'email', ignoreRecord: true)
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

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query->where('annee_id', self::$annee->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenoms')
                    ->label('Prénoms')
                    ->searchable(),
                PhoneColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_naissance')
                    ->dateTime(format: 'l d F Y')
                    ->placeholder('Non renseigné'),
                Tables\Columns\TextColumn::make('lieu_naissance')
                    ->label('Lieu de naissance')
                    ->placeholder('Non renseigné')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sexe')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('situation_matrimoniale')
                    ->label('Situation matrimoniale')
                    ->placeholder('Non renseigné')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nb_enfants')
                    ->label("Nombre d'enfants")
                    ->toggleable(isToggledHiddenByDefault: true),

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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Employés'),
            ])
            ->actions([
                //                Tables\Actions\Action::make('cotisations')
                ////                    ->url(fn ($record) => static::getUrl('cotisations', ['record' => $record]))
                //                    ->icon('heroicon-o-currency-dollar')
                //                    ->color('success')
                //                    ->label('Cotisations'),
                //                Tables\Actions\Action::make('payer')
                //                    ->icon('heroicon-o-banknotes')
                //                    ->color('tertiary')
                //                    ->form([
                //                        Forms\Components\Section::make('Paiements')
                //                            ->schema([
                //                                Forms\Components\Select::make('type_paiement_id')
                //                                    ->label('Type de paiement')
                //                                    ->required()
                //                                    ->searchable()
                //                                    ->live()
                //                                    ->preload()
                //                                    ->options(TypePaiement::query()->where('nom', '!=', 'Salaire')->pluck('nom', 'id'))
                //                                    ->createOptionForm([
                //                                        Forms\Components\TextInput::make('nom')
                //                                            ->required()
                //                                            ->maxLength(255),
                //                                    ])
                //                                    ->optionsLimit(3),
                //                                Forms\Components\TextInput::make('solde')
                //                                    ->label('Montant')
                //                                    ->required()
                //                                    ->numeric()
                //                                    ->live(onBlur: true)
                //                                    ->hidden(fn(Forms\Get $get) => $get('type_paiement_id') == TypePaiement::SALAIRE)
                //                                    ->maxValue(function (Employee $record, Forms\Get $get) {
                //                                        if ($get('type_paiement_id') == TypePaiement::AVANCE) {
                //                                            return $record->salaire / 2;
                //                                        }
                //                                    })
                //                                    ->default(5000)
                //                                    ->suffix('FCFA'),
                //                                Forms\Components\Select::make('mode_paiement_id')
                //                                    ->label('Mode de paiement')
                //                                    ->searchable()
                //                                    ->options(ModePaiement::query()->pluck('nom', 'id'))
                //                                    ->preload()
                //                                    ->columnSpan(function (Forms\Get $get) {
                //                                        return $get('type_paiement_id') == TypePaiement::SALAIRE ? 2 : 1;
                //                                    })
                //                                    ->optionsLimit(3)
                //                                    ->required(),
                //                                Forms\Components\DateTimePicker::make('date_debut')
                //                                    ->helperText('Intervalle du service payé')
                //                                    ->hidden()
                //                                    ->columnSpan(2)
                //                                    ->label('Date de début'),
                //                                Forms\Components\DateTimePicker::make('date_fin')
                //                                    ->helperText('Intervalle du service payé')
                //                                    ->hidden()
                //                                    ->columnSpan(2)
                //                                    ->label('Date de fin'),
                //                                Forms\Components\TextInput::make('nb_jours_travaille')
                //                                    ->numeric()
                //                                    ->label('Nombre de jours travaillés')
                //                                    ->default(function (Employee $record) {
                //                                        return CalculerSalaireMensuel::nbreJoursTravaille($record);
                //                                    })
                //                                    ->required(),
                //                                Forms\Components\TextInput::make('pas')
                //                                    ->label('Echelon')
                //                                    ->visible(fn(Forms\Get $get) => $get('type_paiement_id') == TypePaiement::PRET)
                //                                    ->columnSpan(2)
                //                                    ->helperText('Echelonner le paiement')
                //                                    ->numeric(),
                //
                //                            ])->columns(2),
                //                        //                        $this->getContentSection(),
                //
                //                    ])
                //                    ->action(function (array $data, Employee $record) {
                //                        try {
                //                            Notification::make('paiement operer')
                //                                ->title('Paiement opéré')
                //                                ->body('Paiement opéré. Cependant, veuillez vérifier le statut(payé) du paiement')
                //                                ->success()
                //                                ->iconColor('tertiary')
                //                                ->icon('heroicon-o-banknotes')
                //                                ->send();
                //                        } catch (Exception $e) {
                //                            Notification::make('paiement non operer')
                //                                ->title('Paiement non opéré')
                //                                ->body('Paiement non opéré. Veuillez réessayer')
                //                                ->danger()
                //                                ->iconColor('tertiary')
                //                                ->icon('heroicon-o-banknotes')
                //                                ->send();
                //
                //                        }
                //                        $record->paiements()->create($data);
                //                    })
                //                    ->label('Effectuer un paiement'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //                    Tables\Actions\BulkAction::make('salaire')
                    //                        ->color('tertiary')
                    //                        ->requiresConfirmation()
                    //                        ->form([
                    //                            Forms\Components\Select::make('mode_paiement_id')
                    //                                ->searchable()
                    //                                ->label('Mode de paiement')
                    //                                ->live(onBlur: true)
                    //                                ->options(ModePaiement::query()->pluck('nom', 'id'))
                    //                                ->preload(),
                    //                            Forms\Components\Select::make('type_paiement_id')
                    //                                ->searchable()
                    //                                ->live(onBlur: true)
                    //                                ->hidden()
                    //                                ->preload()
                    //                                ->default(TypePaiement::SALAIRE)
                    //                                ->options(TypePaiement::query()->where('nom', '!=', 'Salaire')->pluck('nom', 'id'))
                    //                                ->createOptionForm([
                    //                                    Forms\Components\TextInput::make('nom')
                    //                                        ->required()
                    //                                        ->maxLength(255),
                    //                                ])
                    //                                ->optionsLimit(3),
                    //                        ])
                    //                        ->icon('heroicon-o-banknotes')
                    //                        ->action(function (array $data, $records) {
                    //                            $donnes = [SoldeCompte::SALAIRE_MENSUEL, SoldeCompte::TREIZIEME_MOIS, SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU, SoldeCompte::PREAVIS, SoldeCompte::AVANCE_SUR_SALAIRE, SoldeCompte::PRET_ENTREPRISE, SoldeCompte::TOTAL];
                    //
                    //                            foreach ($records as $record) {
                    //                                $salaire_mensuel = (new CalculerSalaireMensuel())->handle($record);
                    //                                $startDate = new DateTime($record->demandeConges()->where('statut', 'paye')->first()?->date_debut);
                    //                                $endDate = new DateTime($record->demandeConges()->where('statut', 'paye')->first()?->date_fin);
                    //                                $montantJoursCongesPaye = date_diff($startDate, $endDate)->days * $record->solde_jours_conges_payes;
                    //                                $montantAvanceSalaire = $record->paiements()->where('type_paiement_id', TypePaiement::AVANCE)->sum('solde');
                    //                                $prets = CalculerSalaireMensuel::sommePrets($record);
                    //                                Paiement::updateOrCreate([
                    //                                    'employee_id' => $record->id,
                    //                                ], [
                    //                                    'date_paiement' => now(),
                    //                                    'employee_id' => $record->id,
                    //                                    'statut' => 'effectue',
                    //                                    'solde' => $salaire_mensuel,
                    //                                    'mode_paiement_id' => $data['mode_paiement_id'],
                    //                                    'type_paiement_id' => TypePaiement::SALAIRE,
                    //                                ]);
                    //                                foreach ($donnes as $donne) {
                    //                                    $record->soldeComptes()->updateOrCreate([
                    //                                        'mois' => now()->format('F'),
                    //                                        'employee_id' => $record->id,
                    //                                        'donnees' => $donne,
                    //                                    ],
                    //                                        [
                    //                                            'mois' => now()->format('F'),
                    //                                            'donnees' => $donne,
                    //                                            'montant' => match ($donne) {
                    //                                                SoldeCompte::SALAIRE_MENSUEL => $salaire_mensuel,
                    //                                                SoldeCompte::TREIZIEME_MOIS => 0,
                    //                                                SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU => $montantJoursCongesPaye,
                    //                                                SoldeCompte::PREAVIS => 0,
                    //                                                SoldeCompte::AVANCE_SUR_SALAIRE => $montantAvanceSalaire,
                    //                                                SoldeCompte::PRET_ENTREPRISE => $prets,
                    //                                                SoldeCompte::TOTAL => $salaire_mensuel + $montantJoursCongesPaye - $montantAvanceSalaire - $prets,
                    //                                            },
                    //                                        ]);
                    //                                }
                    //                            }
                    //                            Notification::make('salaires payes')
                    //                                ->title('Paiement des salaires effectué')
                    //                                ->body('Paiement des salaires effectué. Veuillez vérifier les paiements effectués dans la liste des paiements')
                    //                                ->color('tertiary')
                    //                                ->iconColor('tertiary')
                    //                                ->icon('heroicon-o-banknotes')
                    //                                ->send();
                    //                            redirect(EmployeeResource::getUrl('salaires-paiements', ['records' => $records->pluck('id')->implode(',')]));
                    //                        })
                    ////                        ->url(fn($records) => EmployeeResource::getUrl('salaires-paiements', ['records' => $records]))
                    ////                        ->requiresConfirmation()
                    //                        ->label('Payer Salaire'),
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

    public static function getRelations(): array
    {
        return [
            ContratsRelationManager::class,
            //            DemandeCongesRelationManager::class,
            //            AbsencesRelationManager::class,
            //            MisAPiedsRelationManager::class,
            //            PrimesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
            'salaires-paiements' => Pages\SalaireBulkPage::route('/{records}/salaires-paiements'),
            'solde' => Pages\SoldePage::route('/{record}/solde'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Employee::where('annee_id', self::$annee->id)->count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nom', 'prenoms'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return "$record->nom, $record->prenoms"; // TODO: Change the autogenerated stub
    }
}

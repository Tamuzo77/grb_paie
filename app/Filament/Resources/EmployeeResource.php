<?php

namespace App\Filament\Resources;

use App\Actions\CalculerSalaireMensuel;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers\AbsencesRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\DemandeCongesRelationManager;
use App\Models\Employee;
use App\Models\ModePaiement;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use App\Models\TypePaiement;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $modelLabel = 'Employés';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'nom';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Entreprise d\'appartenance')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->live()
                            ->relationship('client', 'nom')
                            ->searchable()
                            ->hintIcon('heroicon-o-building-office-2')
                            ->hintColor('accent')
                            ->required()
                            ->columnSpanFull()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\TextInput::make('categorie')
                            ->label('Catégorie')
                            ->maxLength(10)
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
                            ->grouped()
                            ->inline(),
                        Forms\Components\DatePicker::make('date_embauche'),
                        Forms\Components\DatePicker::make('date_depart'),

                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make(label: 'Informations personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('npi')
                            ->label('Numero d\' idendentification personnelle (NPI)')
                            ->maxLength(16)
                            ->numeric()
                            ->default(null),
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->maxLength(8),
                        Forms\Components\TextInput::make('prenoms')
                            ->label('Prénoms')
                            ->maxLength(15)
                            ->default(null),
                        Forms\Components\TextInput::make('telephone')
                            ->tel()
                            ->prefix('+229')
                            ->maxLength(8)
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\DatePicker::make('date_naissance'),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->maxLength(20)
                            ->default(null),
                        Forms\Components\TextInput::make('situation_matrimoniale')
                            ->maxLength(15)
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
                            ->required()
                            ->numeric()
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
                            ->maxLength(255)
                            ->numeric()
                            ->default(null),
                        Forms\Components\TextInput::make('salaire')
                            ->required()
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0),
                        Forms\Components\TextInput::make('tauxCnss')
                            ->numeric()
                            ->maxLength(2)
                            ->suffix('%')
                            ->default(0),

                    ]),
                Forms\Components\Fieldset::make(label: 'Informations complémentaires')
                    ->schema([
                        Forms\Components\TextInput::make('nb_jours_conges_acquis')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('solde_jours_conges_payes')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.nom')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenoms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->searchable(),
                Tables\Columns\IconColumn::make('cadre')
                    ->boolean(),
                Tables\Columns\TextColumn::make('salaire')
                    ->numeric()
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
            ->actions([
                Tables\Actions\Action::make('cotisations')
//                    ->url(fn ($record) => static::getUrl('cotisations', ['record' => $record]))
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->label('Cotisations'),
                Tables\Actions\Action::make('payer')
                    ->requiresConfirmation()
                    ->modalDescription('Voulez-vous vraiment effectuer un paiement pour cet employé ?')
                    ->icon('heroicon-o-banknotes')
                    ->color('tertiary')
                    ->action(function () {

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
                        ->action(function (array $data, $records ) {
                            $donnes = [SoldeCompte::SALAIRE_MENSUEL, SoldeCompte::TREIZIEME_MOIS, SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU, SoldeCompte::PREAVIS, SoldeCompte::AVANCE_SUR_SALAIRE, SoldeCompte::PRET_ENTREPRISE];

                            foreach ($records as $record) {
                                Paiement::create([
                                    'date_paiement' => now(),
                                    'employee_id' => $record->id,
                                    'statut' => 'effectue',
                                    'solde' => (new CalculerSalaireMensuel())->handle($record),
                                    'mode_paiement_id' => $data['mode_paiement_id'],
                                    'type_paiement_id' => TypePaiement::SALAIRE
                                ]);
                                foreach ($donnes as $donne) {
                                    $record->soldeComptes()->firstOrCreate([
                                        'mois' => now()->format('F'),
                                        'employee_id' => $record->id,
                                        'donnees' => $donne,
                                    ],
                                        [
                                            'mois' => now()->format('F'),
                                            'donnees' => $donne,
                                            'montant' => match ($donne) {
                                                SoldeCompte::SALAIRE_MENSUEL => (new CalculerSalaireMensuel())->handle($record),
                                                SoldeCompte::TREIZIEME_MOIS => 0,
                                                SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU => $record->demandeConges()->where('statut', 'paye')->count() * $record->solde_jours_conges_payes,
                                                SoldeCompte::PREAVIS => 0,
                                                SoldeCompte::AVANCE_SUR_SALAIRE => $record->paiements()->where('type_paiement_id', 1)->sum('solde'),
                                                SoldeCompte::PRET_ENTREPRISE => 0,
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

    public static function getRelations(): array
    {
        return [
            DemandeCongesRelationManager::class,
            AbsencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
            'salaires-paiements' => Pages\SalaireBulkPage::route('/{records}/salaires-paiements'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Employee::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nom', 'prenoms'];
    }
}

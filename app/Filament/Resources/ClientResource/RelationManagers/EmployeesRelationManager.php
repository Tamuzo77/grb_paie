<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\ModePaiement;
use App\Models\TypePaiement;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use PHPUnit\Exception;

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
                    ->icon('heroicon-o-banknotes')
                    ->color('tertiary')
                    ->form([
                        Forms\Components\Section::make('Paiements')
                            ->schema([
                                Forms\Components\TextInput::make('solde')
                                    ->required()
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->hidden(fn (Forms\Get $get) => $get('type_paiement_id') == TypePaiement::SALAIRE)
                                    ->maxValue(function (Employee $record, Forms\Get $get) {
                                        if ($get('type_paiement_id') == TypePaiement::AVANCE) {
                                            return $record->salaire;
                                        }
                                    })
                                    ->default(fn (Employee $record) => $record->salaire)
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
                                Forms\Components\Select::make('type_paiement_id')
                                    ->label('Type de paiement')
                                    ->required()
                                    ->columnSpan(2)
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
                                Forms\Components\DateTimePicker::make('date_debut')
                                    ->helperText('Intervalle du service payé')
                                    ->columnSpan(2)
                                    ->label('Date de début'),
                                Forms\Components\DateTimePicker::make('date_fin')
                                    ->helperText('Intervalle du service payé')
                                    ->columnSpan(2)
                                    ->label('Date de fin'),

                            ])->columns(4),
                        //                        $this->getContentSection(),

                    ])
                    ->action(function (array $data, Employee $record) {
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
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('salaire')
                        ->color('tertiary')
                        ->icon('heroicon-o-banknotes')
                        ->action(function ($records) {

                            $this->redirect(EmployeeResource::getUrl('salaires-paiements', ['records' => $records->pluck('id')->implode(',')]));
                        })
//                        ->url(fn($records) => EmployeeResource::getUrl('salaires-paiements', ['records' => $records]))
                        ->requiresConfirmation()
                        ->label('Payer Salaire'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}

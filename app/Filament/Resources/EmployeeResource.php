<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $modelLabel = 'Employés';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                            ->maxLength(255)
                            ->default(null),
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

                    ]),
                Forms\Components\Fieldset::make(label: 'Informations personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('npi')
                            ->label('Numero d\' idendentification personnelle (NPI)')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('prenoms')
                            ->label('Prénoms')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('telephone')
                            ->tel()
                            ->prefix('+229')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\DatePicker::make('date_naissance'),
                        Forms\Components\TextInput::make('lieu_naissance')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('situation_matrimoniale')
                            ->maxLength(255)
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
                            ->default(null),
                        Forms\Components\TextInput::make('salaire')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('tauxCnss')
                            ->numeric()
                            ->maxLength(2)
                            ->suffix('%')
                            ->default(null),

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
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('annee_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenoms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_naissance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lieu_naissance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('situation_matrimoniale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sexe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nb_enfants')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_embauche')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_depart')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->searchable(),
                Tables\Columns\IconColumn::make('cadre')
                    ->boolean(),
                Tables\Columns\TextColumn::make('salaire')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('numero_compte')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tauxIts')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tauxCnss')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nb_jours_conges_acquis')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('solde_jours_conges_payes')
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
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}

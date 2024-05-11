<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContratResource\Pages;
use App\Filament\Resources\ContratResource\RelationManagers;
use App\Models\Contrat;
use App\Services\ItsService;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContratResource extends Resource
{
    protected static ?string $model = Contrat::class;
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public  static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'nom')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nom}")
                            ->required()
                            ->columnSpan(3)
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\Select::make('employee_id')
                            ->label('Employé')
                            ->relationship('employee', 'nom')
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nom} {$record->prenoms}")
                            ->required()
                            ->columnSpan(3)
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie')
                            ->relationship('category', 'nom')
                            ->searchable()
                            ->columnSpan(3)
                            ->required()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\Select::make('fonction_id')
                            ->label('Fonction')
                            ->relationship(name: 'fonction', titleAttribute: 'nom')
                            ->searchable()
                            ->columnSpan(3)
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nom')
                                    ->required()
                                    ->maxLength(255),
                            ])
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
                            ->columnSpan(2)
                            ->date()
                            ->after('date_debut'),
                        Forms\Components\TextInput::make('salaire_brut')
                            ->label('Salaire brut')
                            ->required()
                            ->columnSpan(3)
                            ->live(onBlur: true)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->suffix('FCFA')
                            ->numeric()
                            ->afterStateUpdated(fn(Forms\Set $set, $state) => $set('tauxIts', ItsService::getIts(intval($state)))
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.nom')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.nom')
                    ->label('Nom de l\'employé')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.prenoms')
                    ->label('Prénoms de l\'employé')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_signature')
                    ->dateTime(format: 'd/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Date de signature'),
                Tables\Columns\TextColumn::make('date_debut')
                    ->dateTime(format: 'd/m/Y')
                    ->searchable()
                    ->label('Date de début'),
                Tables\Columns\TextColumn::make('date_fin')
                    ->dateTime(format: 'd/m/Y')
                    ->placeholder('Non défini')
                    ->searchable()
                    ->label('Date de fin'),
                Tables\Columns\TextColumn::make('fonction.nom')
                    ->searchable()
                    ->label('Fonction'),
                Tables\Columns\TextColumn::make('category.nom')
                    ->searchable()
                    ->label('Catégorie'),
                Tables\Columns\TextColumn::make('salaire_brut')
                    ->searchable()
                    ->label('Salaire brut'),
                Tables\Columns\TextColumn::make('nb_jours_conges_acquis')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Nombre de jours de congés acquis'),
                Tables\Columns\TextColumn::make('solde_jours_conges_payes')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Solde de jours de congés payés'),
                Tables\Columns\TextColumn::make('tauxIts')
                    ->searchable()
                    ->label('Taux ITS'),
                Tables\Columns\BooleanColumn::make('est_cadre')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Cadre'),
                Tables\Columns\TextColumn::make('statut')
                    ->searchable()
                    ->icon(function ($record) {
                        return match ($record->statut) {
                            'En cours' => 'heroicon-o-check-circle',
                            'Clos' => 'heroicon-o-x-circle',
                            default => 'heroicon-o-question-mark-circle',
                        };
                    })
                    ->color(function ($record) {
                        return match ($record->statut) {
                            'En cours' => 'success',
                            'Clos' => 'danger',
                            default => 'warning',
                        };
                    })
                    ->sortable()
                    ->label('Statut'),
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
            RelationManagers\DemandeCongesRelationManager::class,
            RelationManagers\AbsencesRelationManager::class,
            RelationManagers\MisAPiedsRelationManager::class,
            RelationManagers\PrimesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContrats::route('/'),
            'create' => Pages\CreateContrat::route('/create'),
            'edit' => Pages\EditContrat::route('/{record}/edit'),
        ];
    }
}

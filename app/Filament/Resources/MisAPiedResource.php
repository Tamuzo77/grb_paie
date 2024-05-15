<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MisAPiedResource\Pages;
use App\Models\MisAPied;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class MisAPiedResource extends Resource
{
    protected static ?string $model = MisAPied::class;

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    protected static ?string $modelLabel = 'Mise à pied';

    protected static ?string $pluralModelLabel = 'Mises à pied';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationGroup = 'Dépendances salariales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Mises à pied')
                    ->description('Enregsitrement ')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('contrat_id')
                            ->label('Employé')
                            ->hintColor('accent')
                            ->relationship('employee', titleAttribute: 'slug',modifyQueryUsing: fn ($query) => $query->where('statut', 'En cours'))
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->employee->nom} {$record->employee->prenoms} ({$record->client->nom})")
                            ->hintIcon('heroicon-o-user-group')
                            ->searchable()
                            ->required()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\TextInput::make('montant')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('nbre_jours')
                            ->label('Nombre de jours')
                            ->required()
                            ->numeric()
                            ->default(0),
                        // ->beforeOrEqual($date_debut>addDays(11)),
                        ButtonGroup::make('type')
                            ->options([
                                'Conservatoire' => 'Conservatoire',
                                'Disciplinaire' => 'Disciplinaire',
                            ])
                            ->label('Type')
                            ->onColor('primary')
                            ->offColor('gray')
                            ->gridDirection('col')
                            ->default('Conservatoire')
                            ->icons([
                                'Conservatoire' => 'heroicon-m-user',
                                'Disciplinaire' => 'heroicon-m-building-office',
                            ])
                            ->iconPosition(\Filament\Support\Enums\IconPosition::After)
                            ->iconSize(IconSize::Medium)
                            ->required(),
                        Forms\Components\Textarea::make('motif'),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.employee.nom')
                    ->label('Employé')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nbre_jours')
                    ->label('Nombre de jours')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListMisAPieds::route('/'),
            'create' => Pages\CreateMisAPied::route('/create'),
            'edit' => Pages\EditMisAPied::route('/{record}/edit'),
        ];
    }
}

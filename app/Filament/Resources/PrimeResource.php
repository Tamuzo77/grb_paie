<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrimeResource\Pages;
use App\Models\Prime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PrimeResource extends Resource
{
    protected static ?string $model = Prime::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $modelLabel = 'Prime';

    protected static ?string $pluralModelLabel = 'Primes';

    protected static ?int $navigationSort = 50;

    protected static ?string $navigationGroup = 'Dépendances salariales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Primes')
                    ->description('Enregsitrement ')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('contrat_id')
                            ->label('Employé')
                            ->hintColor('accent')
                            ->relationship('employee', titleAttribute: 'slug', modifyQueryUsing: fn ($query) => $query->where('statut', 'En cours'))
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
                        // ->beforeOrEqual($date_debut>addDays(11)),
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->default(now()),

                    ])
                    ->columns(3),
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
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime(format: 'd F Y')
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
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListPrimes::route('/'),
            'create' => Pages\CreatePrime::route('/create'),
            'edit' => Pages\EditPrime::route('/{record}/edit'),
        ];
    }
}

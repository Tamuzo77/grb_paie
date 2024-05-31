<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource\Pages;
use App\Models\PositionHierachique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PositionHierachiqueResource extends Resource
{
    protected static ?string $model = PositionHierachique::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Settings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('niveau')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1),

                Forms\Components\Select::make('parent_id')
                    ->label('Position supérieure')
                    ->relationship('positionHierachique', 'nom')
                    ->default(null),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->default(null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('niveau')
                    ->numeric()
                    ->placeholder('Non renseigné')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->placeholder('Non renseigné')
                    ->formatStateUsing(fn (string $state) => str($state)->markdown()->toHtmlString())
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('positionHierachique.nom')
                    ->label('Position supérieure')
                    ->placeholder('Non renseigné')
                    ->searchable(),
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
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListPositionHierachiques::route('/'),
            'create' => Pages\CreatePositionHierachique::route('/create'),
            'edit' => Pages\EditPositionHierachique::route('/{record}/edit'),
        ];
    }
}

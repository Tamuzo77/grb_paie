<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Clusters\Settings\Resources\AnneeResource\Pages;
use App\Models\Annee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnneeResource extends Resource
{
    protected static ?string $model = Annee::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $cluster = Settings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('debut')
                    ->required(),
                Forms\Components\DatePicker::make('fin')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('nom')
                    ->label('Année')
                    ->searchable(),
                Tables\Columns\TextColumn::make('debut')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fin')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Toutes')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Années'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
//                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                    Tables\Actions\RestoreBulkAction::make(),
//                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListAnnees::route('/'),
            //            'create' => Pages\CreateAnnee::route('/create'),
            'edit' => Pages\EditAnnee::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Settings\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use App\Filament\Clusters\Settings;
use Tables\Actions\DeleteBulkAction;
use App\Filament\Clusters\Settings\Resources\AnneeResource\Pages;

class AnneeResource extends Resource
{
    protected static ?string $model = Annee::class;
    protected static ?string $modelLabel = 'Année d\'exercice';

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
                Forms\Components\Select::make('statut')
                    ->options([
                        'en_cours' => 'En cours',
                        'cloture' => 'Clôturée',
                    ])
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
                    ->label('Début')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fin')
                    ->label('Fin')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statut')
                    ->icon(fn (string $state): string => match ($state) {
                        'en_cours' => 'heroicon-o-lock-open',
                        'cloture' => 'heroicon-o-lock-closed',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'cloture' => 'gray',
                        'en_cours' => 'success',
                        default => 'accent',
                    })
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

                Tables\Actions\Action::make('Rapport Annuel')
                ->color(Color::Teal)
                ->label('Rapport Annuel')
                ->visible(Annee::latest()->first()?->statut == 'cloture')
                ->icon('heroicon-o-document-text'),

                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                //\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    DeleteBulkAction::make(),
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

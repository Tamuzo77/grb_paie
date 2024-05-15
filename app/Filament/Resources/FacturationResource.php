<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacturationResource\Pages;
use App\Filament\Resources\FacturationResource\RelationManagers;
use App\Models\Facturation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FacturationResource extends Resource
{
    protected static ?string $model = Facturation::class;

    protected static ?string $navigationGroup = 'Paiements et Facturations';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', titleAttribute: 'nom')
                    ->preload()
                    ->searchable()
                    ->hint('Sélectionnez le client concerné par la facturation')
                    ->columnSpanFull()
                    ->optionsLimit(7)
                    ->required(),
                Forms\Components\DateTimePicker::make('date_debut'),
                Forms\Components\DateTimePicker::make('date_fin'),
//                Forms\Components\TextInput::make('taux')
//                    ->required()
//                    ->numeric()
//                    ->default(0),
//                Forms\Components\TextInput::make('total_salaire_brut')
//                    ->required()
//                    ->numeric()
//                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.nom')
                    ->label('Client')
                    ->searchable(isIndividual: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->label('Date de début')
                    ->dateTime(format: ' d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->dateTime(format: ' d/m/Y')
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('taux')
                    ->label('Taux (%)')
                    ->rules(['required', 'numeric'])
                    ->placeholder('10'),
                Tables\Columns\TextColumn::make('total_salaire_brut')
                    ->label('Total des salaires brut')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant_facture')
                    ->label('Montant de la facture')
                    ->placeholder('N/A')
                    ->numeric()
                    ->sortable(),
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
                Tables\Filters\TrashedFilter::make()
                    ->label('Corbeille')
                    ->columnSpan(1),
            ])
            ->actions([
                Tables\Actions\Action::make('details')
                    ->label('Détails')
                    ->action(function (Facturation $record) {
                        redirect()->route('download-facturation', $record->id);
                    })
                    ->icon('heroicon-o-information-circle'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make()
                ])
                    ->color('neutral')
                    ->label('Actions')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make()
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
            'index' => Pages\ListFacturations::route('/'),
//            'create' => Pages\CreateFacturation::route('/create'),
//            'edit' => Pages\EditFacturation::route('/{record}/edit'),
        ];
    }
}

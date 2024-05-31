<?php

namespace App\Filament\Clusters\Settings\Resources;

use App\Filament\Clusters\Settings;
use App\Filament\Clusters\Settings\Resources\BankResource\Pages;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $modelLabel = 'Banque';

    protected static ?string $navigationIcon = 'far-building';

    protected static ?string $navigationLabel = 'Banques';

    protected static ?string $navigationBadgeTooltip = 'Gestion des banques';

    protected static ?string $cluster = Settings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(heading: 'Informations sur la banque')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                    ])->columnSpan(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //                Tables\Columns\TextColumn::make('code')
                //                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->description(fn (Bank $record) => "Code: {$record->code}")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Création')
                    ->dateTime(format: 'd F Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière modification')
                    ->dateTime(format: 'd F Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Suppression')
                    ->dateTime(format: 'd F Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //                Tables\Filters\TernaryFilter::make('deleted_at')
                //                    ->label('Corbeille')
                //                    ->placeholder('Sans banques archivées')
                //                    ->trueLabel('Avec banques archivées')
                //                    ->falseLabel('Banques archivées seulement')
                //                    ->queries(
                //                        true: fn (Builder $query) => $query->withTrashed()->get(),
                //                        false: fn (Builder $query) => $query->onlyTrashed()->get(),
                //                        blank: fn (Builder $query) => $query->withoutTrashed()->get(),
                //                    )
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Avec banques archivées')
                    ->falseLabel('Banques archivées seulement')
                    ->label('Corbeille')
                    ->placeholder('Sans banques archivées'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBank::route('/create'),
            'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}

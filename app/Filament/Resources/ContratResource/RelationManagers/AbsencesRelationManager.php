<?php

namespace App\Filament\Resources\ContratResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AbsencesRelationManager extends RelationManager
{
    protected static string $relationship = 'absences';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Absences')
                    ->description('Enregsitrement des absences de l\' employé')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date_debut')
                            ->required()
                            ->label('Date de début'),
                        Forms\Components\DateTimePicker::make('date_fin')
                            ->required()
                            ->label('Date de fin'),
                        ToggleButtons::make('deductible')
                            ->label('Est elle déductible ?')
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
                        Forms\Components\Textarea::make('motif')
                            ->default(null),
                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('deductible')
            ->columns([
                Tables\Columns\IconColumn::make('deductible')
                    ->icon(function ($record) {
                        return $record->deductible ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle';
                    })
                    ->color(function ($record) {
                        return $record->deductible ? 'success' : 'error';
                    }),
                Tables\Columns\TextColumn::make('date_debut')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}

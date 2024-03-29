<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DemandeCongesRelationManager extends RelationManager
{
    protected static string $relationship = 'demandeConges';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Demande de congés')
                    ->description('Enregsitrement des demandes de congés de l\' employé')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date_debut'),
                        Forms\Components\DateTimePicker::make('date_fin'),
                        ToggleButtons::make('statut')
                            ->label('Statut')
                            ->options([
                                'paye' => 'Payé',
                                'non paye' => 'Non Payé',
                            ])
                            ->colors([
                                'paye' => 'accent',
                                'non paye' => 'error',
                            ])
                            ->grouped()
                            ->inline(),
                    ]),

            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('statut')
            ->columns([
                Tables\Columns\TextColumn::make('statut'),
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

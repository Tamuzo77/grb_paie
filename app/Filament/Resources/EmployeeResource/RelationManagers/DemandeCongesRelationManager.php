<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use App\Models\Employee;
use Closure;
use DateTime;
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
                        Forms\Components\DateTimePicker::make('date_debut')
                            ->required()
                            ->date(),
                        Forms\Components\DateTimePicker::make('date_fin')
                            ->required()
                            ->rules([
                                fn(Forms\Get $get,): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    $startDate = new DateTime($get('date_debut'));
                                    $endDate = new DateTime($value);
                                    $nbre_jours = date_diff($startDate, $endDate)->days;
                                    $nbre_jours_acquis = $this->getOwnerRecord()->nb_jours_conges_acquis;
                                    if ($nbre_jours > $nbre_jours_acquis) {
                                        $fail(' Le nombre de jours de congés demandés est supérieur au nombre de jours de congés acquis');
                                    }
                                },
                            ])
                            ->date()
                            ->after('date_debut'),
                        // ->beforeOrEqual($date_debut>addDays(11)),
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
                            ->required()
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
                Tables\Columns\TextColumn::make('statut')
                    ->badge(fn($record) => match ($record->statut) {
                        'paye' => 'success',
                        'non paye' => 'accent',
                    }),
                Tables\Columns\TextColumn::make('date_debut')
                    ->label('Date de début')
                    ->dateTime(format: 'd F Y')
//                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->label('Date de fin')
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

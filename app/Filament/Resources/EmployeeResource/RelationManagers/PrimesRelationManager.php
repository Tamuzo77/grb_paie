<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class PrimesRelationManager extends RelationManager
{
    protected static string $relationship = 'primes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Primes')
                    ->description('Enregsitrement ')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->readOnly()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('montant')
                            ->required()
//                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('nom', state: 'Prime de  '.$state.' FCFA'))
                            ->default(0),
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->default(now()),

                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('montant')
            ->columns([
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

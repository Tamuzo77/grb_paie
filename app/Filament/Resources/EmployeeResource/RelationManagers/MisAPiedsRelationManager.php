<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class MisAPiedsRelationManager extends RelationManager
{
    protected static string $relationship = 'misAPieds';
    protected static ?string $modelLabel = 'Mise à pied';
    protected static ?string $pluralModelLabel = 'Mises à pied';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Mises à pied')
                    ->description('Enregsitrement ')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->readOnly()
                            ->default(function(Forms\Get $get) {
                                return "Mise à pied de {$this->getOwnerRecord()->nom} {$this->getOwnerRecord()->prenoms} pour {$get('nbre_jours')} jours";
                            })
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('montant')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('nbre_jours')
                            ->label('Nombre de jours')
                            ->required()
                            ->numeric()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                return $set('nom', state: "Mise à pied de {$this->getOwnerRecord()->nom} {$this->getOwnerRecord()->prenoms} pour {$state} jours");
                            })
                            ->default(0),
                        // ->beforeOrEqual($date_debut>addDays(11)),
                        ButtonGroup::make('type')
                            ->options([
                                'Conservatoire' => 'Conservatoire',
                                'Disciplinaire' => 'Disciplinaire',
                            ])
                            ->columns(3)
                            ->label('Type')
                            ->onColor('primary')
                            ->offColor('gray')
                            ->gridDirection('row',)
                            ->default('Conservatoire')
                            ->icons([
                                'Conservatoire' => 'heroicon-m-user',
                                'Disciplinaire' => 'heroicon-m-building-office',
                            ])
                            ->iconPosition(\Filament\Support\Enums\IconPosition::After)
                            ->iconSize(IconSize::Medium)
                            ->required(),
                        Forms\Components\Textarea::make('motif'),

                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nbre_jours')
                    ->label('Nombre de jours')
                    ->numeric()
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

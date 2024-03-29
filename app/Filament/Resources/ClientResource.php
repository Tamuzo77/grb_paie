<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\EmployeesRelationManager;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $recordTitleAttribute = 'nom';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations sur le client')
                    ->description('Description détaillée')
                    ->schema([
                        Forms\Components\Fieldset::make('Client ou Entreprise')
                            ->schema([
                                Forms\Components\TextInput::make('matricule')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nom')
                                    ->required()
                                    ->helperText('Nom complet')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('adresse')
                                    ->required()
                                    ->helperText('Adresse de l\'entreprise')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('telephone')
                                    ->prefix('+229')
                                    ->tel()
                                    ->hint('Contact téléphonique')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('bank_id')
                                    ->label('Banque')
                                    ->live()
                                    ->relationship('bank', 'code')
                                    ->searchable()
                                    ->required()
                                    ->optionsLimit(5)
                                    ->preload(),
                                Forms\Components\TextInput::make('nom_donneur_ordre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('prenom_donneur_ordre')
                                    ->required()
                                    ->label('Prénoms donneur ordre')
                                    ->maxLength(255),
                            ])
                            ->grow(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matricule')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom_donneur_ordre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom_donneur_ordre')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Clients'),
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
            EmployeesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'nom',
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Client::count();
    }
}

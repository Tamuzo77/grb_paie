<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Paramètres';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->imageEditor()
                            ->uploadingMessage('Chargement de l\' avatar...')
                            ->storeFiles()
                            ->directory('usersAvatars')
                            ->avatar()
                            ->default(null),
                    ])->columnSpan(1),
                    Forms\Components\Section::make('Informations sur l\'utilisateur')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nom')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('surname')
                                ->maxLength(255)
                                ->hidden()
                                ->default(null),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->columnSpan(1)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->label('Téléphone')
                                ->prefix('+229')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpanFull(),
                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query->where('id', '!=', 1);
            })
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar')
                        ->defaultImageUrl(fn (User $record): string => "https://ui-avatars.com/api/?name={$record->name}&background=random")
                        ->circular(),
                    Tables\Columns\TextColumn::make('name')
                        ->label('Nom')
                        ->sortable()
                        ->weight(FontWeight::Bold)
                        ->description(fn ($record) => $record->surname)
                        ->searchable(),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('email')
                            ->tooltip(tooltip: 'Adresse email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->wrap(condition: true)
                            ->searchable(),
                        Tables\Columns\TextColumn::make('phone')
                            ->label('Téléphone')
                            ->icon('heroicon-m-phone')
                            ->tooltip('Numéro de téléphone')
                            ->copyable()
                            ->searchable(),
                    ])->alignEnd(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Utilisateurs'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Aucun utilisateur')
            ->emptyStateDescription('Il n\'y a aucun utilisateur pour le moment. Veuillez en créer un.');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name', 'email', 'surname',
        ];
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'name';
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return "$record->name, $record->email"; // TODO: Change the autogenerated stub
    }

    public static function getNavigationBadge(): ?string
    {
        return User::where('id', '!=', 1)->count();
    }
}

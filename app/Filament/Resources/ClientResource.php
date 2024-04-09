<?php

namespace App\Filament\Resources;

use App\Events\EtatsPersonnelEvent;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\EmployeesRelationManager;
use App\Models\Annee;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ClientResource extends Resource
{
    use InteractsWithPageFilters;
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $recordTitleAttribute = 'nom';
    protected static ?Annee $annee = null;

    public function __construct()
    {
        $annee = Annee::whereSlug($filters['annee_id'] ?? now()->year)->firstOrFail();
        self::$annee = $annee;

    }
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
                                    ->unique(ignoreRecord: true)
                                    ->alphaNum(true)
                                    ->minLength(6)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nom')
                                    ->required()
                                    ->helperText('Nom complet')
                                    ->maxLength(255)
                                    ->label('Nom de la structure'),
                                Forms\Components\TextInput::make('adresse')
                                    ->required()
                                    ->helperText('Adresse de l\'entreprise')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('telephone')
//                                    ->prefix('+229')
                                    ->placeholder('Ex: +229 97 97 97 97')
                                    ->tel()
                                    ->label('Téléphone')
                                    ->hint('Contact téléphonique')
                                    ->required()
                                    ->unique(ignoreRecord : true)
                                    ->numeric(),
//                                    ->maxLength(8),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord : true)
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
            ->query(function (){
                return Client::query()
                    ->where('annee_id', self::$annee->id);
            })
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
                Tables\Actions\Action::make('cotisations')
                    ->url(fn ($record) => static::getUrl('cotisations', ['record' => $record]))
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->label('Cotisations'),
                Tables\Actions\Action::make('etats')
                    ->requiresConfirmation()
                    ->action(function ($record){
                        try {
                            redirect(route('download-etats-personnel', $record->id));

                            Notification::make('Etat personnel téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement de l\'état personnel a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send()
                                ->sendToDatabase(auth()->user(),true);
                        }catch (\Exception $e) {
                            Notification::make('Erreur lors du téléchargement de l\'état personnel')
                                ->title('Erreur')
                                ->body("Une erreur s'est produite lors du téléchargement de l'état personnel. Veuillez réessayer.")
                                ->color('danger')
                                ->iconColor('danger')
                                ->send()
                                ->sendToDatabase(auth()->user(), true);
                        }
//                        EtatsPersonnelEvent::dispatch($record);
                    })
                    ->icon('heroicon-o-table-cells')
                    ->color(Color::Sky)
                    ->label('Etats'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ]),

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
            'cotisations' => Pages\CotisationsClient::route('/{record}/cotisations'),
            'etats-personnel' => Pages\EtatsPersonelPage::route('/{record}/etats-personnel'),
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
        return Client::where('annee_id', self::$annee?->id)->count();
    }


}

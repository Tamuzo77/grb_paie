<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaiementResource\Pages;
use App\Models\Annee;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Paiement;
use App\Models\TypePaiement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaiementResource extends Resource
{
    protected static ?string $model = Paiement::class;

    protected static ?string $navigationGroup = 'Etats et Paiements';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 1;

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
                Forms\Components\Select::make('client_id')
                    ->live()
                    ->searchable()
                    ->required()
                    ->label('Client')
                    ->dehydrated(false)
                    ->options(Client::all()->pluck('nom', 'id')),
                Forms\Components\Select::make('employee_id')
                    ->label('Employé')
                    ->placeholder(fn (Forms\Get $get) => empty($get('client_id')) ? 'Sélectionner un client' : 'Sélectionner un employé')
                    ->hintColor('accent')
                    ->options(function (Forms\Get $get) {
                        return Employee::where('client_id', $get('client_id'))->get()->pluck('nom', 'id');
                    })
//                            ->relationship('employee', modifyQueryUsing: fn(Builder $query) => $query->orderBy('nom')->orderBy('prenoms'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nom} {$record->prenoms}")
                    ->hintIcon('heroicon-o-user-group')
                    ->searchable(['nom', 'prenoms'])
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('solde', Employee::whereId($state)->first()->salaire ?? 0))
                    ->required()
                    ->optionsLimit(5)
                    ->preload(),
                Forms\Components\DateTimePicker::make('date_debut')
                    ->date()
                    ->required(),
                Forms\Components\DateTimePicker::make('date_fin')
                    ->date()
                    ->required()
                    ->after('date_debut'),
                Forms\Components\TextInput::make('solde')
                    ->label('Solde (defaut: salaire)')
                    ->numeric(),
                Forms\Components\Select::make('mode_paiement_id')
                    ->label('Mode de paiement')
                    ->searchable()
                    ->relationship('modePaiement', 'nom')
                    ->preload()
                    ->columnSpan(1)
                    ->optionsLimit(3)
                    ->required(),
                Forms\Components\Select::make('type_paiement_id')
                    ->label('Type de paiement')
                    ->required()
                    ->columnSpan(2)
                    ->searchable()
                    ->preload()
                    ->relationship('typePaiement', 'nom')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->optionsLimit(3),

                ToggleButtons::make('statut')
                    ->label('Statut')
                    ->options([
                        'paye' => 'Payé',
                        'en attente' => 'En attente',
                    ])
                    ->colors([
                        'paye' => 'accent',
                        'en attente' => 'error',
                    ])
                    ->default('en attente')
                    ->grouped()
                    ->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->where('annee_id', self::$annee->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('employee.client.nom')
                    ->searchable(isIndividual: true, isGlobal: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.nom')
                    ->description(fn ($record) => $record->employee->prenoms, position: 'above')
                    ->separator()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('solde')
                    ->numeric()
//                    ->money(currency: 'XOF')
                    ->suffix('  FCFA')
                    ->sortable(),
                Tables\Columns\TextColumn::make('typePaiement.nom')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modePaiement.nom')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(format: 'd F Y')
                    ->label('Créé le')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(format: 'd F Y')
                    ->label('Modifié le')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(format: 'd F Y')
                    ->label('Supprimé le')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                'employee.client.nom',
            ])
            ->reorderable()
            ->recordUrl(null)
            ->filters([
                Filter::make('date_debut')
                    ->form([
                        DatePicker::make('from')
                            ->label('Du'),
                        DatePicker::make('until')
                            ->label('Au'),
                    ])->query(function ($query, array $data) {
                        return $query->when($data['from'], fn ($query) => $query->whereDate('date_debut', '>=', $data['from']))
                            ->when($data['until'], fn ($query) => $query->whereDate('date_debut', '<=', $data['until']));
                    }),

            ])
            ->actions([
                //                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('voir solde')
                    ->color(Color::Teal)
                    ->label('Voir Solde')
                    ->url(function (Paiement $paiement) {
                        $employee = Employee::where('id', $paiement->employee_id)->firstOrFail();

                        return EmployeeResource::getUrl('solde', ['record' => $employee]);
                    })
                    ->icon('heroicon-o-currency-dollar'),
                Tables\Actions\Action::make('fiche_de_paie')
                    ->color(Color::Fuchsia)
                    ->label('Fiche de paie')
                    ->visible(fn (Paiement $record) => $record->type_paiement_id == TypePaiement::SALAIRE)
                    ->requiresConfirmation()
                    ->action(function (Paiement $record) {
                        try {
                            redirect(route('download-fiche-de-paie', $record->id));

                            Notification::make('Fiche de paie téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement de la fiche de paie a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send()
                                ->sendToDatabase(auth()->user(), true);
                        } catch (\Exception $e) {
                            Notification::make('Erreur lors du téléchargement de la fiche de paie')
                                ->title('Erreur')
                                ->body("Une erreur s'est produite lors du téléchargement de l'état personnel. Veuillez réessayer.")
                                ->color('danger')
                                ->iconColor('danger')
                                ->send()
                                ->sendToDatabase(auth()->user(), true);
                        }
                    })
                    ->icon('heroicon-o-document-text'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPaiements::route('/'),
            'create' => Pages\CreatePaiement::route('/create'),
            'edit' => Pages\EditPaiement::route('/{record}/edit'),
        ];
    }
}

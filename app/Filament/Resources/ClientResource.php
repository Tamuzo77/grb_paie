<?php

namespace App\Filament\Resources;

use App\Actions\GenereCode;
use App\Events\EtatsPersonnelEvent;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\EmployeesRelationManager;
use App\Models\Annee;
use App\Models\Client;
use App\Models\CotisationClient;
use App\Models\CotisationEmploye;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class ClientResource extends Resource
{
    use InteractsWithPageFilters;

    const string HEROICON_O_PHONE = 'heroicon-o-phone';

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
                                    ->readOnly()
                                    ->unique(ignoreRecord: true)
                                    ->alphaNum(true)
                                    ->default((new GenereCode())->handle(Client::class, 'C'))
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
                                PhoneInput::make('telephone')
//                                    ->prefix('+229')
                                    ->label('Téléphone')
                                    ->hint('Contact téléphonique')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('nom_donneur_ordre')
                                    ->label('Nom & Prénoms du donneur ordre')
                                    ->columns(1)
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ifu')
                                    ->placeholder('Ex: 1234567890123')
                                    ->helperText('Numéro IFU de l\'entreprise')
                                    ->label('Numéro IFU'),
                                Forms\Components\Select::make('bank_id')
                                    ->label('Banque')
                                    ->live()
                                    ->relationship('bank', 'code')
                                    ->searchable()
                                    ->columnSpan(fn($component) => $component->getContainer()->getComponent('tauxCnss') ? 1 : 2)
                                    ->required()
                                    ->optionsLimit(5)
                                    ->preload(),
                                Forms\Components\TextInput::make('tauxCnss')
                                    ->key('tauxCnss')
                                    ->label('Taux CNSS')
                                    ->hint('Taux  CNSS')
                                    ->numeric()
                                    ->hiddenOn('edit')
                                    ->suffix('%')
                                    ->default(3.6)
                                    ->columns(1)
                                    ->required(),
                                Forms\Components\FileUpload::make('rc')
                                    ->label('Registre de commerce')
                                    ->previewable(true)
                                    ->directory('rc')
                                    ->preserveFilenames()
                                    ->columnSpan('full')
                                    ->downloadable(true)
//                                    ->required()
                                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                                    ->hint('Fichier PDF ou image'),
                                //                                    ->maxFiles(1),
                            ])
                            ->columns(3)
                            ->grow(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Client::query()
                    ->where('annee_id', self::$annee->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('matricule')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                PhoneColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom_donneur_ordre')
                    ->label('Donneur ordre')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Clients'),
            ])
            ->recordUrl(fn($record) => static::getUrl('view', ['record' => $record]))
            ->actions([
                Tables\Actions\Action::make('cotisations')
                    ->action(function ($record) {
                        $mois = [
                            'January' => 'Janvier',
                            'February' => 'Février',
                            'March' => 'Mars',
                            'April' => 'Avril',
                            'May' => 'Mai',
                            'June' => 'Juin',
                            'July' => 'Juillet',
                            'August' => 'Août',
                            'September' => 'Septembre',
                            'October' => 'Octobre',
                            'November' => 'Novembre',
                            'December' => 'Décembre',
                        ];
                        $sommeCotisations = 0;
                        $sommeSalaireBrut = 0;
                        foreach ($mois as $mo) {
                            CotisationClient::updateOrCreate([
                                'client_id' => $record->id,
                                'annee_id' => self::$annee->id,
                                'agent' => $mo,
                            ], [
                                'client_id' => $record->id,
                                'annee_id' => self::$annee->id,
                                'agent' => $mo,
                                'somme_cotisations' => 0,
                                'somme_salaires_bruts' => 0,
                            ]);

                            if ($mo == 'Mars' || $mo == 'Juin' || $mo == 'Septembre' || $mo == 'Décembre') {
                                $trimestre = $mo == 'Mars' ? 'Trimestre 1' : ($mo == 'Juin' ? 'Trimestre 2' : ($mo == 'Septembre' ? 'Trimestre 3' : 'Trimestre 4'));

                                CotisationClient::updateOrCreate([
                                    'client_id' => $record->id,
                                    'annee_id' => self::$annee->id,
                                    'agent' => $trimestre,
                                ], [
                                    'client_id' => $record->id,
                                    'annee_id' => self::$annee->id,
                                    'agent' => $trimestre,
                                ]);
                            }

                        }

                        foreach ($record->employees as $employee) {
                            $sommeSalaireBrut += $employee->salaire_brut;
                            $sommeCotisations += $employee->salaire_brut * 0.23;
                        }
                        $currentMonth = now()->format('F');
                        CotisationClient::updateOrCreate([
                            'client_id' => $record->id,
                            'annee_id' => self::$annee->id,
                            'agent' => $mois[$currentMonth],
                        ], [
                            'client_id' => $record->id,
                            'annee_id' => self::$annee->id,
                            'agent' => $mois[$currentMonth],
                            'somme_cotisations' => $sommeCotisations,
                            'somme_salaires_bruts' => $sommeSalaireBrut,
                        ]);

                        CotisationClient::updateOrCreate([
                            'client_id' => $record->id,
                            'annee_id' => self::$annee->id,
                            'agent' => 'Total',
                        ], [
                            'client_id' => $record->id,
                            'annee_id' => self::$annee->id,
                            'agent' => 'Total',
                        ]);
                        redirect(static::getUrl('cotisations', ['record' => $record]));
                    })
//                    ->url(fn ($record) => static::getUrl('cotisations', ['record' => $record]))
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->label('Cotisations'),
                Tables\Actions\Action::make('etats')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        try {
                            redirect(route('download-etats-personnel', $record->id));

                            Notification::make('Etat personnel téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement de l\'état personnel a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send()
                                ->sendToDatabase(auth()->user(), true);
                        } catch (\Exception $e) {
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
                Tables\Actions\Action::make('cotisations-employes')
                    ->action(function ($record) {
                        $sommeCnss = 0;
                        $sommeIts = 0;
                        $sommeTotal = 0;
                        foreach ($record->employees()->where(fn($query) => $query->where('date_debut', '<=', now())
                            ->where('date_fin', '>=', now())
                            ->where('statut', 'En cours')
                            ->orWhereNull('date_fin'))->get() as $employee) {
                            $cnss = $record->tauxCnss ? $employee->salaire_brut * $record->tauxCnss : $employee->salaire_brut * 0.036;
                            $its = $employee->tauxIts ? $employee->salaire_brut * $employee->tauxIts : $employee->salaire_brut * 0.05;
                            $total = $cnss + $its;
                            CotisationEmploye::updateOrCreate([
                                'client_id' => $record->id,
                                'agent' => "{$employee->employee->nom} {$employee->employee->prenoms}",
                                'annee_id' => self::$annee->id,
                                'mois' => now()->format('F'),
                            ], [
                                'client_id' => $record->id,
                                'agent' => "{$employee->employee->nom} {$employee->employee->prenoms}",
                                'annee_id' => self::$annee->id,
                                'cnss' => $cnss,
                                'its' => $its,
                                'total' => $total,
                                'mois' => now()->format('F'),
                            ]);
                            $sommeCnss = $sommeCnss + $cnss;
                            $sommeIts = $sommeIts + $its;
                            $sommeTotal = $sommeTotal + $total;
                        }
                        CotisationEmploye::updateOrCreate([
                            'client_id' => $record->id,
                            'agent' => 'Total',
                            'annee_id' => self::$annee->id,
                            'mois' => now()->format('F'),
                        ], [
                            'client_id' => $record->id,
                            'agent' => 'Total',
                            'annee_id' => self::$annee->id,
                            'cnss' => $sommeCnss,
                            'its' => $sommeIts,
                            'total' => $sommeTotal,
                            'mois' => now()->format('F'),
                        ]);
                        redirect(static::getUrl('cotisations-employes', ['record' => $record]));
                    })
                    ->icon('heroicon-o-currency-dollar')
                    ->color(Color::Orange)
                    ->label('Cotisations employés'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('facturation')
                        ->form([
                            Forms\Components\DatePicker::make('date_debut')
                                ->label('Date de début')
                                ->required(),
                            Forms\Components\DatePicker::make('date_fin')
                                ->label('Date de fin')
                                ->after('date_debut')
                                ->required(),
                        ])
                        ->action(function ( array $data ,$records) {
                            foreach ($records as $record) {
                                $record->facturations()->updateOrCreate([
                                    'date_debut' => $data['date_debut'],
                                    'date_fin' => $data['date_fin'],
                                ],[
                                    'montant_facture' => 0,
                                    'taux' => 0,
                                    'date_debut' => $data['date_debut'],
                                    'date_fin' => $data['date_fin'],
                                ]);
                            }

                            redirect(FacturationResource::getUrl('index'));
                        })
                        ->icon('heroicon-o-currency-dollar')
                        ->label('Facturer'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        $record = $infolist->record;

        return $infolist->schema([
            Split::make([
                Section::make('Informations Générales')
                    ->description('Informations sur le client')
                    ->icon(self::$navigationIcon)
                    ->headerActions([
                        Action::make('edit')
                            ->label('Modifier')
                            ->url(function () use ($record) {
                                return static::getUrl('edit', ['record' => $record]);
                            }),
                    ])
                    ->schema([
                        TextEntry::make('matricule')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Matricule'),
                        TextEntry::make('nom')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(FontWeight::Bold)
                            ->label('Nom'),
                        TextEntry::make('adresse')
                            ->copyable()
                            ->size(TextEntry\TextEntrySize::Large)
                            ->limit(25)
                            ->label('Adresse'),
                        TextEntry::make('ifu')
                            ->placeholder('Pas d\'IFU')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('IFU'),
                        TextEntry::make('bank.name')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Banque'),
                        TextEntry::make('nom_donneur_ordre')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Nom donneur ordre'),
                        TextEntry::make('prenom_donneur_ordre')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Prénoms donneur ordre'),

                    ])
                    ->compact()
                    ->columns(3)
                    ->columnSpan(3)
                    ->footerActions([
                        Action::make('rc')
                            ->visible(fn() => $record->rc)
                            ->action(function () use ($record) {
                                return response()->download(storage_path("app/public/{$record->rc}"));
                            })
                            ->label('Télécharger Registre de commerce'),
                    ])
                    ->collapsible(),
                Section::make('Informations de contacts')
                    ->description('Informations de contacts')
                    ->icon(self::HEROICON_O_PHONE)
                    ->schema([
                        TextEntry::make('telephone')
                            ->copyable()
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Téléphone'),
                        TextEntry::make('email')
                            ->copyable()
                            ->size(TextEntry\TextEntrySize::Large)
                            ->label('Email'),
                    ])
                    ->columns(1)
                    ->grow(false)
                    ->collapsible(),
            ])
                ->columns(4)
                ->columnSpanFull(),

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
            'view' => Pages\ViewClient::route('/{record}'),
            'cotisations' => Pages\CotisationsClient::route('/{record}/cotisations'),
            'etats-personnel' => Pages\EtatsPersonelPage::route('/{record}/etats-personnel'),
            'cotisations-employes' => Pages\CotisationsEmployes::route('/{record}/cotisations-employes'),
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemandeCongeResource\Pages;
use App\Models\Client;
use App\Models\DemandeConge;
use App\Models\Employee;
use Closure;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DemandeCongeResource extends Resource
{
    protected static ?string $model = DemandeConge::class;

    protected static ?string $modelLabel = 'Congés';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Dépendances salariales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Demande de congés')
                    ->description('Enregsitrement des demandes de congés des employés')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->live()
                            ->required()
                            ->searchable()
                            ->label('Client')
                            ->dehydrated(false)
                            ->options(Client::pluck('nom', 'id')),
                        Forms\Components\Select::make('employee_id')
                            ->label('Employé')
                            ->placeholder(fn (Forms\Get $get) => empty($get('client_id')) ? 'Sélectionner un client' : 'Sélectionner un employé')
                            ->hintColor('accent')
                            ->selectablePlaceholder(fn (Forms\Get $get): bool => empty($get('client_id')))
                            ->options(function (?DemandeConge $record, Forms\Get $get, Forms\Set $set) {
                                $employees = Employee::where('client_id', $get('client_id'))->pluck('nom', 'id');
                                if (! is_null($record) && $get('client_id') == null) {
                                    $set('client_id', $record->employee->client_id);
                                    $employees = Employee::where('client_id', $get('client_id'))->pluck('nom', 'id');
                                    $set('client_id', array_key_first($employees->toArray()));
                                }

                                return $employees;
                            })
//                            ->relationship('employee', modifyQueryUsing: fn(Builder $query) => $query->orderBy('nom')->orderBy('prenoms'))
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nom} {$record->prenoms}")
                            ->hintIcon('heroicon-o-user-group')
                            ->searchable(['nom', 'prenoms'])
                            ->required()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\DateTimePicker::make('date_debut')
                            ->required()
                            ->date(),
                        Forms\Components\DateTimePicker::make('date_fin')
                            ->required()
                            ->rules([
                                fn (Forms\Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    $startDate = new DateTime($get('date_debut'));
                                    $endDate = new DateTime($value);
                                    $nbre_jours = date_diff($startDate, $endDate)->days;
                                    $nbre_jours_acquis = Employee::find($get('employee_id'))->nb_jours_conges_acquis;
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.client.nom')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.nom')
                    ->label('Employé')
                    ->description(fn ($record) => $record->employee->prenoms)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->label('Date de début')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->label('Date de fin')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statut')
                    ->icon(fn (string $state): string => match ($state) {
                        'non paye' => 'heroicon-o-x-circle',
                        'paye' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'non paye' => 'gray',
                        'paye' => 'success',
                        default => 'accent',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(format: 'd F Y')
                    ->label('Créé le')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime(format: 'd F Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime(format: 'd F Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->trueLabel('Historique')
                    ->falseLabel('Archives')
                    ->label('Corbeille')
                    ->placeholder('Employés'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDemandeConges::route('/'),
            'create' => Pages\CreateDemandeConge::route('/create'),
            'edit' => Pages\EditDemandeConge::route('/{record}/edit'),
        ];
    }
}

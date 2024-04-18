<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenceResource\Pages;
use App\Models\Absence;
use App\Models\Client;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbsenceResource extends Resource
{
    protected static ?string $model = Absence::class;

    protected static ?string $modelLabel = 'Absences';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Dépendances salariales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Absences')
                    ->description('Enregsitrement des absences des employés')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->live()
                            ->searchable()
                            ->label('Client')
                            ->required()
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
                            ->required()
                            ->optionsLimit(5)
                            ->preload(),
                        Forms\Components\DateTimePicker::make('date_debut')
                            ->required()
                            ->date(),
                        Forms\Components\DateTimePicker::make('date_fin')
                            ->required()
                            ->date()
                            ->after('date_debut'),
                        ToggleButtons::make('deductible')
                            ->label('Est elle déductible ?')
                            ->options([
                                '1' => 'Oui',
                                '0' => 'Non',
                            ])
                            ->colors([
                                '1' => 'accent',
                                '0' => 'error',
                            ])
                            ->grouped()
                            ->inline(),
                        Forms\Components\Textarea::make('motif')
                            ->default(null),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.client.nom')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('employee.nom')
                    ->description(fn ($record) => $record->employee->prenoms)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->dateTime(format: 'd F Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('deductible')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-x-circle',
                        '1' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'gray',
                        '1' => 'success',
                        default => 'accent',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Crée le')
                    ->dateTime(format: 'd F Y')
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
            'index' => Pages\ListAbsences::route('/'),
            'create' => Pages\CreateAbsence::route('/create'),
            'edit' => Pages\EditAbsence::route('/{record}/edit'),
        ];
    }
}

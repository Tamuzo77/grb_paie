<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\SoldeCompte;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class SoldePage extends ListRecords
{
    use InteractsWithRecord;

    protected static string $resource = EmployeeResource::class;

    protected ?string $heading = 'Solde de tout compte';

    public function mount(): void
    {
        $this->record = Employee::whereSlug(request('record'))->first();

    }

    public function getBreadcrumb(): ?string
    {
        return 'Solde de compte'; // TODO: Change the autogenerated stub
    }

    /**
     * @return string|null
     */
    public function table(Table $table): Table
    {
        return $table
            ->heading('Employé: '.$this->record->nom.' '.$this->record->prenoms)
            ->query(SoldeCompte::query()->where('employee_id', $this->record->id))
            ->recordUrl(null)
            ->columns([
                TextColumn::make('donnees')
                    ->weight(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? TextColumn\TextColumnSize::Large : null),
                TextColumn::make('montant')
                    ->weight(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr')
                    ->prefix(function ($record) {
                        if ($record->donnees == SoldeCompte::TOTAL) {
                            return ' ';
                        }

                        return $record->donnees == SoldeCompte::SALAIRE_MENSUEL || $record->donnees == SoldeCompte::TREIZIEME_MOIS || $record->donnees == SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU || $record->donnees == SoldeCompte::PREAVIS ? '+ ' : '- ';
                    })
                    ->disabled(fn ($record) => $record->donnees == SoldeCompte::SALAIRE_MENSUEL || $record->donnees == SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU || $record->donnees == SoldeCompte::TOTAL),

            ])
            ->paginated(false)
            ->filters([
                SelectFilter::make('mois')
                    ->default(now()->format('F'))
                    ->options([
                        'January' => 'Janvier',
                        'Februray' => 'Février',
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
                    ]),
            ])
            ->headerActions([
                //                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                //                    ->exports([
                //                        ExcelExport::make()
                //                            ->fromTable()
                //                            ->withFilename($this->record->nom . ' ' . $this->record->prenoms . ' - Solde Compte'),
                //                    ]),
                Action::make('export')
                    ->label('Exporter')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        try {
                            redirect(route('download-soldes', ['records' => $this->getTableRecords()->pluck('id')->implode(',')]));

                            Notification::make('Etat personnel téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement de l\'état personnel a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make('Erreur lors du téléchargement de l\'état personnel')
                                ->title('Erreur')
                                ->body("Une erreur s'est produite lors du téléchargement de l'état personnel. Veuillez réessayer.")
                                ->color('danger')
                                ->iconColor('danger')
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                //                ExportBulkAction::make()
                //                    ->exports([
                //                        ExcelExport::make()
                //                            ->fromTable()
                //                            ->withFilename($this->record->nom . ' ' . $this->record->prenoms . ' - Solde Compte'),
                //                    ]),
            ]);
    }
}

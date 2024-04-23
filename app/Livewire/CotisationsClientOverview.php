<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\CotisationClient;
use App\Models\Employee;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Concerns\HasTabs;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CotisationsClientOverview extends Component implements HasForms, HasTable
{
    use HasTabs, InteractsWithForms, InteractsWithTable;

    public $client;

    public function mount(Client $client): void
    {
        $this->client = $client;

    }

    public function render()
    {
        return view('livewire.cotisations-client-overview');
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Exporter'),
        ];
    }

    public function getTableRecordKey(Model $record): string
    {
        return 'id';
    }

    public function table(Table $table): Table
    {
        $currentYear = date('Y');

        return $table
            ->recordUrl(null)
            ->query(function () {
                //                return Employee::query()
                ////                    ->selectRaw('QUARTER(paiements.date_paiement) AS trimestre, MONTHNAME(paiements.date_paiement) AS mois, SUM(employees.salaire) AS total, SUM(employees.salaire * 0.23) AS cotisations')
                ////                    ->join('paiements', 'employees.id', '=', 'paiements.employee_id')
                ////                    ->where('employees.client_id', $this->client->id)
                ////                    ->whereBetween('paiements.date_paiement', ["$currentYear-01-01", "$currentYear-12-31"])
                ////                    ->groupBy('trimestre', 'mois')
                ////                    ->orderBy('trimestre') // Tri par trimestre
                ////                    ->orderByRaw("FIELD(mois, 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre')");
                //                    ->selectRaw('QUARTER(NOW()) AS trimestre,MONTHNAME(NOW()) AS mois, SUM(employees.salaire) AS total, SUM(employees.salaire * 0.23) AS cotisations')
                //                    ->where('employees.client_id', $this->client->id)
                //                    ->groupBy('mois', 'trimestre');
                return CotisationClient::query()->where('client_id', $this->client->id);
            })
            ->columns([
                //                TextColumn::make('trimestre')
                //                    ->label('Trimestre'),
                TextColumn::make('agent')
                    ->weight(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? FontWeight::SemiBold : ($record->agent == 'Total' ? FontWeight::ExtraBold : null))
                    ->size(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? TextColumn\TextColumnSize::Medium : ($record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null))
                    ->label('Agent'),
                TextColumn::make('somme_salaires_bruts')
                    ->weight(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? FontWeight::SemiBold : ($record->agent == 'Total' ? FontWeight::ExtraBold : null))
                    ->size(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? TextColumn\TextColumnSize::Medium : ($record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null))
                    ->default(function ($record) {
//                        if ($record->agent == 'Trimestre 1') {
//                            $janvier = CotisationClient::where('agent', 'Janvier')->first()->somme_salaires_bruts;
//                            $fevrier = CotisationClient::where('agent', 'Février')->first()->somme_salaires_bruts;
//                            $mars = CotisationClient::where('agent', 'Mars')->first()->somme_salaires_bruts;
//
//                            return $janvier + $fevrier + $mars;
//                        } elseif ($record->agent == 'Trimestre 2') {
//                            $avril = CotisationClient::where('agent', 'Avril')->first()->somme_salaires_bruts;
//                            $mai = CotisationClient::where('agent', 'Mai')->first()->somme_salaires_bruts;
//                            $juin = CotisationClient::where('agent', 'Juin')->first()->somme_salaires_bruts;
//
//                            return $avril + $mai + $juin;
//                        } elseif ($record->agent == 'Trimestre 3') {
//                            $juillet = CotisationClient::where('agent', 'Juillet')->first()->somme_salaires_bruts;
//                            $aout = CotisationClient::where('agent', 'Aout')->first()->somme_salaires_bruts;
//                            $septembre = CotisationClient::where('agent', 'Septembre')->first()->somme_salaires_bruts;
//
//                            return $juillet + $aout + $septembre;
//                        } elseif ($record->agent == 'Trimestre 4') {
//                            $octobre = CotisationClient::where('agent', 'Octobre')->first()->somme_salaires_bruts;
//                            $novembre = CotisationClient::where('agent', 'Novembre')->first()->somme_salaires_bruts;
//                            $decembre = CotisationClient::where('agent', 'Decembre')->first()->somme_salaires_bruts;
//
//                            return $octobre + $novembre + $decembre;
//                        } elseif ($record->agent == 'Total') {
////                            $total = CotisationClient::where('client_id', $this->client->id)->sum('somme_salaires_bruts');
//                            $total = 0;
//                            return $total;
//                        }

                        return 0;
                    })
                    ->label('Total des salaires brutes'),
                TextColumn::make('somme_cotisations')
                    ->weight(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? FontWeight::SemiBold : ($record->agent == 'Total' ? FontWeight::ExtraBold : null))
                    ->size(fn($record) => $record->agent == 'Trimestre 1' || $record->agent == 'Trimestre 2' || $record->agent == 'Trimestre 3' || $record->agent == 'Trimestre 4' ? TextColumn\TextColumnSize::Medium : ($record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null))
                    ->default(function ($record) {
//                        if ($record->agent == 'Trimestre 1') {
//                            $janvier = CotisationClient::where('agent', 'Janvier')->first()->somme_cotisations;
//                            $fevrier = CotisationClient::where('agent', 'Février')->first()->somme_cotisations;
//                            $mars = CotisationClient::where('agent', 'Mars')->first()->somme_cotisations;
//
//                            return $janvier + $fevrier + $mars;
//                        } elseif ($record->agent == 'Trimestre 2') {
//                            $avril = CotisationClient::where('agent', 'Avril')->first()->somme_cotisations;
//                            $mai = CotisationClient::where('agent', 'Mai')->first()->somme_cotisations;
//                            $juin = CotisationClient::where('agent', 'Juin')->first()->somme_cotisations;
//
//                            return $avril + $mai + $juin;
//                        } elseif ($record->agent == 'Trimestre 3') {
//                            $juillet = CotisationClient::where('agent', 'Juillet')->first()->somme_cotisations;
//                            $aout = CotisationClient::where('agent', 'Aout')->first()->somme_cotisations;
//                            $septembre = CotisationClient::where('agent', 'Septembre')->first()->somme_cotisations;
//
//                            return $juillet + $aout + $septembre;
//                        } elseif ($record->agent == 'Trimestre 4') {
//                            $octobre = CotisationClient::where('agent', 'Octobre')->first()->somme_cotisations;
//                            $novembre = CotisationClient::where('agent', 'Novembre')->first()->somme_cotisations;
//                            $decembre = CotisationClient::where('agent', 'Decembre')->first()->somme_cotisations;
//
//                            return $octobre + $novembre + $decembre;
//                        } elseif ($record->agent == 'Total') {
////                            $total = CotisationClient::where('client_id', $this->client->id)->sum('somme_cotisations');
//
//                            return 0;
//                        }

                        return 0;
                    })
                    ->label('23%'),

            ])
            ->paginated(false)
            ->striped()
            ->headerActions([
                //                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                //                    ->exports([
                //                        ExcelExport::make('table')
                //                            ->fromTable()
                //                            ->withFilename('cotisations'),
                //                    ])
                //                    ->label('Exporter'),
                Action::make('export')
                    ->label('Exporter')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        try {
                            redirect(route('download-cotisations-clients', ['records' => $this->getTableRecords()->pluck('id')->implode(',')]));

                            Notification::make('Cotisation du client téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement des cotisations du client a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make('Erreur lors du téléchargement')
                                ->title('Erreur')
                                ->body("Une erreur s'est produite lors du téléchargement. Veuillez réessayer.")
                                ->color('danger')
                                ->iconColor('danger')
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                //                ExportBulkAction::make()
                //                    ->exports([
                //                        ExcelExport::make('table')
                //                            ->fromTable()
                //                            ->withFilename('cotisations'),
                //                    ])
                //                    ->label('Exporter'),

            ])
            ->emptyStateHeading('Aucune cotisation(s) sociale(s) enregistrée(s)')
            ->emptyStateDescription('Aucune cotisation(s) sociale(s) enregistrée(s)');
    }

    public function getTabs(): array
    {
        return [
            'par mois' => Tab::make(),
            'par employee' => Tab::make()
                ->modifyQueryUsing(function ($query) {
                    $query->selectRaw('MONTHNAME(paiements.date_paiement) as mois,QUARTER(paiements.date_paiement) as trimestre,SUM(employees.salaire) as total,SUM(employees.salaire * 0.23) as cotisations, employees.id')
                        ->join('paiements', 'employees.id', '=', 'paiements.employee_id')
                        ->where('employees.client_id', $this->client->id)
                        ->where('paiements.type_paiement_id', '4') //type = salaire
                        ->where('paiements.statut', 'paye')
                        ->groupBy(['mois', 'employees.id', 'trimestre']);
                }),
        ];
    }

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }
}

<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\CotisationClient;
use App\Models\Employee;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Components\Tab;
use Filament\Resources\Concerns\HasTabs;
use Filament\Support\Contracts\TranslatableContentDriver;
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
                    ->label('Agent'),
                TextColumn::make('somme_salaires_bruts')
                    ->label('Total des salaires brutes'),
                TextColumn::make('somme_cotisations')
                    ->label('23%'),

            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->exports([
                        ExcelExport::make('table')
                            ->fromTable()
                            ->withFilename('cotisations'),
                    ])
                    ->label('Exporter'),
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

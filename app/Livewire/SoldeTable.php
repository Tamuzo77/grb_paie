<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\SoldeCompte;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class SoldeTable extends Component implements HasForms, HasTable
{
    use HasTabs, InteractsWithForms, InteractsWithTable;

    public $soldeCompte;

    public $employee;

    public function mount(Employee $employee): void
    {
        $this->employee = $employee;

    }

    public function render()
    {
        return view('livewire.solde-table');
    }

    public function table(Table $table)
    {
        return $table
            ->query(SoldeCompte::query()->where('employee_id', $this->employee->id))
            ->columns([
                TextColumn::make('donnees'),
                TextInputColumn::make('montant')
                    ->disabled(fn ($record) => $record->donnees == SoldeCompte::SALAIRE_MENSUEL || $record->donnees == SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU)
                    ->summarize(Sum::make()->label('Total')),
            ])
            ->filters([

            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename($this->employee->nom.' '.$this->employee->prenoms.' - Solde Compte'),
                    ]),
            ])
            ->headerActions([

            ])
            ->paginated(false);

    }
}

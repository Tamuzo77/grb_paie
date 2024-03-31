<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Employee;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class CotisationsClientOverview extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public $client;

    public function mount(Client $client) : void
    {
        $this->client = $client;

    }

    public function render()
    {
        return view('livewire.cotisations-client-overview');
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                Employee::query()
                    ->selectRaw('MONTH(paiements.date_paiement) as mois,SUM(employees.salaire) as total,SUM(employees.salaire * 0.23) as cotisations')
                    ->join('paiements', 'employees.id', '=', 'paiements.employee_id')
                    ->where('employees.client_id', $this->client->id)
                    ->groupBy('mois')
            )
            ->columns([
                TextColumn::make('mois')
                    ->label('Mois'),
                TextColumn::make('total')
                    ->label('Total des salaires brutes' ),
                TextColumn::make('cotisations')
                    ->label('23%'),

            ]);
    }


    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }
}

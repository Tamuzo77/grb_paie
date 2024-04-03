<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Paiement;
use App\Models\TypePaiement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];
    protected function getStats(): array
    {
        $clients = Client::count();
        $employees = Employee::count();
        $paiements = Paiement::count();
        $paiementSalaire = Paiement::where('type_paiement_id', TypePaiement::SALAIRE)->count();
        $paiementAvance = Paiement::where('type_paiement_id', TypePaiement::AVANCE)->count();
        $paiementPret = Paiement::where('type_paiement_id', TypePaiement::PRET)->count();
        return [
            Stat::make(label: 'Clients', value: $clients)
                ->description("+ $clients croissant")
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(label: 'Employés', value: $employees)
                ->description("+ $employees croissant")
                ->color('error')
                ->chart([3, 10, 2, 12, 3, 15, 4])
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(label: 'Paiements', value: $paiements)
                ->description("Salaires: $paiementSalaire, Avances: $paiementAvance, Prêts: $paiementPret")
                ->color('success')
                ->chart([10, 2, 3, 15, 4, 17, 3])
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

        ];
    }
}

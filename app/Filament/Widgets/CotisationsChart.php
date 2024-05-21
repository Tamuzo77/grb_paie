<?php

namespace App\Filament\Widgets;

use App\Models\MisAPied;
use App\Models\Paiement;
use App\Models\Prime;
use App\Models\TypePaiement;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CotisationsChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'cotisationsChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'CotisationsChart';

    protected int|string|array $columnSpan = 'full';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $misAPiedCount = MisAPied::count();

        return [
            'chart' => [
                'type' => 'treemap',
                'height' => 300,
            ],
            'series' => [
                [
                    'data' => [
                        ['x' => 'Mis A Pied', 'y' => $misAPiedCount],
                        ['x' => 'Avances', 'y' => Paiement::where('type_paiement_id', TypePaiement::AVANCE)->count()],
                        ['x' => 'Prêts', 'y' => Paiement::where('type_paiement_id', TypePaiement::PRET)->count()],
                        ['x' => 'Primes', 'y' => Prime::count()],
                    ],
                ],
            ],
            'colors' => ['#2196F3', '#F44336', '#FFC107', '#4CAF50'],
            'legend' => [
                'show' => false,
            ],
        ];
    }
}

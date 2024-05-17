<?php

namespace App\Filament\Widgets;

use App\Models\Paiement;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class SalaireNetMonthly extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'salaireNetMonthly';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Salaires Net payé par mois';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $annee = getAnnee();
        $startDate = Carbon::parse("$annee->nom-01-01");
        $endDate = Carbon::parse("$annee->nom-12-31");
        $data = Trend::model(Paiement::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perMonth()
            ->sum('solde');
        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'SalaireNetMonthly',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn (TrendValue $value) => gmdate('M ', strtotime($value->date))),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#2196F3'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }
}

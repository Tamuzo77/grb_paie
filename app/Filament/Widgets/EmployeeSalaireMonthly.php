<?php

namespace App\Filament\Widgets;

use App\Models\Annee;
use App\Models\Contrat;
use App\Models\Paiement;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class EmployeeSalaireMonthly extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;

//    protected int|string|array $columnSpan = 'full';

    /**
     * Chart Id
     */
    protected static ?string $chartId = 'employeeSalaireMonthly';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Salaires brut par mois';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $annee = getAnnee();
        $startDate = Carbon::parse("$annee->nom-01-01");
        $endDate = Carbon::parse("$annee->nom-12-31");
        $data = Trend::model(Contrat::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perMonth()
            ->sum('salaire_brut');

        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'ParticipantsChart',
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
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }
}

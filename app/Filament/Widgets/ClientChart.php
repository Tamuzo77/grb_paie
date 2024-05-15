<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ClientChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'clientChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'ClientChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'rangeBar',
                'height' => 300,
            ],
            'series' => [
                [
                    'data' => [
                        ['x' => 'Code', 'y' => [1, 3]],
                        ['x' => 'Test', 'y' => [3, 5]],
                        ['x' => 'Validation', 'y' => [5, 8]],
                        ['x' => 'Deployment', 'y' => [8, 12]],
                    ],
                ],
            ],
            'xaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],

                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}

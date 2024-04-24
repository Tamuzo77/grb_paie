<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CotisationClientExport implements FromView, WithEvents, WithStyles
{
    protected $cotisations;

    public function __construct($cotisations)
    {
        $this->cotisations = $cotisations;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.cotisations-client', [
            'cotisations' => $this->cotisations,
        ]);
    }

    public function styles(Worksheet $sheet): array
    {

        return [
            'C7:K7' => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'gray'],
                ],
                'fill' => [
                    'type' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '3498db'],
                ],
            ],
            'C11:K11' => ['font' => ['bold' => true]],
            'C15:K15' => ['font' => ['bold' => true]],
            'C19:K19' => ['font' => ['bold' => true]],
            'C20:K20' => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

            },
            AfterSheet::class => function (AfterSheet $event) {

            },
        ];
    }
}

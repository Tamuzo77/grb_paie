<?php

namespace App\Exports;

use AllowDynamicProperties;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


#[AllowDynamicProperties] class CotisationClientExport implements FromView
{
    protected $cotisations;

    public function __construct($cotisations)
    {
        $this->cotisations = $cotisations;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.cotisations-client', [
            'cotisations' => $this->cotisations
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Appliquer des styles à une cellule ou une plage de cellules
        $sheet->getStyle('C7:K7')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'black'],

            ],
            'fill' => [
                'type' => Fill::FILL_SOLID,
                'color' => ['rgb' => '3498db'],
            ],
        ]);

        // Appliquer des styles à d'autres cellules ou plages de cellules si nécessaire
        $sheet->getStyle('C11:K11')->getFont()->setBold(true);
        $sheet->getStyle('C15:K15')->getFont()->setBold(true);
        $sheet->getStyle('C19:K19')->getFont()->setBold(true);
        $sheet->getStyle('C20:K20')->getFont()->setBold(true);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                // Code à exécuter avant la création de la feuille
                // Par exemple, définir les titres, ajouter des styles spécifiques, etc.
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Code à exécuter après la création de la feuille
                // Par exemple, appliquer des formats de cellules ou des styles.
            },
        ];
    }
}

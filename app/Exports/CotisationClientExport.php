<?php

namespace App\Exports;

use AllowDynamicProperties;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class CotisationClientExport implements FromView
{
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
}

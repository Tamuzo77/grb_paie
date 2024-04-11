<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\CotisationEmploye;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class CotisationEmployeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct( $cotisations)
    {
        $this->cotisations = $cotisations;
    }

    #[\Override] public function view(): View
    {
        return view('exports.cotisations-employe', [
            'records' => $this->cotisations
        ]);
    }
}

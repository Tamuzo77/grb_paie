<?php

namespace App\Exports;


use AllowDynamicProperties;
use App\Models\SoldeCompte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class SoldesExport implements FromView
{
    public function __construct(SoldeCompte $soldes)
    {
        $this->soldes = $soldes ;
    }

    #[\Override] public function view(): View
    {
        return view('exports.soldes', [
            'records' => $this->soldes
        ]);
    }
}

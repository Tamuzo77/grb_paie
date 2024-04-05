<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\Client;
use App\Models\Paiement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class FichePaieExport implements FromView
{

    public function __construct(Paiement $paiement)
    {
        $this->paiement = $paiement;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.fiche-paie', [
            'paiement' => $this->paiement,
        ]);
    }
}

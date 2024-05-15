<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\Contrat;
use App\Models\Facturation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class DetailsFacturationExport implements FromView
{
    public function __construct(Facturation $facturation)
    {
        $this->facturation = $facturation;
    }


    public function view(): View
    {
        $employes = Contrat::where('client_id', $this->facturation->client_id)
            ->where('date_debut', '<=', $this->facturation->date_fin)
            ->where('date_fin', '>=', $this->facturation->date_debut)
            ->whereStatut('En cours')
            ->get();
        return \view('exports.details-facturation', [
            'facturation' => $this->facturation
        ]);
    }
}

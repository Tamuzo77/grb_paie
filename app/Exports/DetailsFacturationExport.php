<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\Contrat;
use App\Models\Facturation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Rmunate\Utilities\SpellNumber;

#[AllowDynamicProperties] class DetailsFacturationExport implements FromView
{
    public function __construct(Facturation $facturation)
    {
        $this->facturation = $facturation;
    }


    public function view(): View
    {
        $employees = Contrat::where('client_id', $this->facturation->client_id)
            ->where('date_debut', '<=', $this->facturation->date_fin)
            ->where('date_fin', '>=', $this->facturation->date_debut)
            ->whereStatut('En cours')
            ->get();
        $montantLettre = SpellNumber::value($this->facturation->montant_facture)->locale('fr')->toLetters();
        return \view('exports.details-facturation', [
            'facturation' => $this->facturation,
            'employees' => $employees,
            'montantLettre' => $montantLettre
        ]);
    }
}

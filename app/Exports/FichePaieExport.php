<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\Client;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Rmunate\Utilities\SpellNumber;

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
        $donnes = [SoldeCompte::SALAIRE_MENSUEL, SoldeCompte::TREIZIEME_MOIS, SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU, SoldeCompte::PREAVIS, SoldeCompte::AVANCE_SUR_SALAIRE, SoldeCompte::PRET_ENTREPRISE, SoldeCompte::TOTAL];
    $solde = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'));
        $salaireMensuel = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::SALAIRE_MENSUEL)->get('montant');
        $montantAvance = SoldeCompte::where('employee_id', $this->paiement->employee_id)->where('mois', now()->format('F'))->where('donnees', \App\Models\SoldeCompte::AVANCE_SUR_SALAIRE)->get('montant');
        $montantLettre = SpellNumber::value($salaireMensuel[0]['montant'])->locale('fr')->toLetters();

        return view('exports.fiche-paie', [
            'paiement' => $this->paiement,
            'employee' => $this->paiement->employee,
            'solde' => $solde,
            'montantAvance' => $montantAvance[0]['montant'],
            'salaireMensuel' => $salaireMensuel[0]['montant'],
            'montantLettre' => $montantLettre,
        ]);
    }
}

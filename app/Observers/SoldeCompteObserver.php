<?php

namespace App\Observers;

use App\Models\SoldeCompte;

class SoldeCompteObserver
{
    /**
     * Handle the SoldeCompte "created" event.
     */
    public function created(SoldeCompte $soldeCompte): void
    {
        //
    }

    /**
     * Handle the SoldeCompte "updated" event.
     */
    public function updated(SoldeCompte $soldeCompte): void
    {
        $salaire_mensuel = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
        $treizieme_mois = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::TREIZIEME_MOIS)->first()->montant;
        $nombre_de_jours_de_conges_payes_du = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU)->first()->montant;
        $preavis = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::PREAVIS)->first()->montant;
        $avance_sur_salaire = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::AVANCE_SUR_SALAIRE)->first()->montant;
        $pret_entreprise = SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::PRET_ENTREPRISE)->first()->montant;
        $total = $salaire_mensuel + $treizieme_mois + $nombre_de_jours_de_conges_payes_du + $preavis - $avance_sur_salaire - $pret_entreprise;
        SoldeCompte::where('employee_id', $soldeCompte->employee_id)->where('donnees', SoldeCompte::TOTAL)->update(['montant' => $total]);
    }

    /**
     * Handle the SoldeCompte "deleted" event.
     */
    public function deleted(SoldeCompte $soldeCompte): void
    {
        //
    }

    /**
     * Handle the SoldeCompte "restored" event.
     */
    public function restored(SoldeCompte $soldeCompte): void
    {
        //
    }

    /**
     * Handle the SoldeCompte "force deleted" event.
     */
    public function forceDeleted(SoldeCompte $soldeCompte): void
    {
        //
    }
}

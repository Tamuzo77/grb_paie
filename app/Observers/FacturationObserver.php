<?php

namespace App\Observers;

use App\Models\Contrat;
use App\Models\Facturation;

class FacturationObserver
{
    /**
     * Handle the Facturation "created" event.
     */
    public function created(Facturation $facturation): void
    {
        $total_salaire_brut = 0;
        Contrat::where('client_id', $facturation->client_id)
            ->where('date_debut', '<=', $facturation->date_fin)
            ->where('date_fin', '>=', $facturation->date_debut)
            ->whereStatut('En cours')
            ->get()->each(function ($contrat) use (&$total_salaire_brut) {
                $total_salaire_brut += $contrat->salaire_brut;
            });
        $facturation->update(['total_salaire_brut' => $total_salaire_brut]);
        $facturation->update(['montant_facture' => $total_salaire_brut * $facturation->taux / 100]);
    }

    /**
     * Handle the Facturation "updated" event.
     */
    public function updated(Facturation $facturation): void
    {
        //        $facturation->update(['montant_facture' => $facturation->total_salaire_brut * $facturation->taux / 100]);
        Facturation::where('id', $facturation->id)->update(['montant_facture' => $facturation->total_salaire_brut * $facturation->taux / 100]);
    }

    /**
     * Handle the Facturation "deleted" event.
     */
    public function deleted(Facturation $facturation): void
    {
        //
    }

    /**
     * Handle the Facturation "restored" event.
     */
    public function restored(Facturation $facturation): void
    {
        //
    }

    /**
     * Handle the Facturation "force deleted" event.
     */
    public function forceDeleted(Facturation $facturation): void
    {
        //
    }
}

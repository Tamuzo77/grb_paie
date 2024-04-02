<?php

namespace App\Observers;

use App\Models\Paiement;

class PaiementObserver
{
    /**
     * Handle the Paiement "created" event.
     */
    public function creating(Paiement $paiement): void
    {
        $paiement->statut = 'en attente';
        $paiement->date_paiement = now();
    }

    public function created(Paiement $paiement): void
    {
        //
    }

    /**
     * Handle the Paiement "updated" event.
     */
    public function updated(Paiement $paiement): void
    {
        //
    }

    /**
     * Handle the Paiement "deleted" event.
     */
    public function deleted(Paiement $paiement): void
    {
        //
    }

    /**
     * Handle the Paiement "restored" event.
     */
    public function restored(Paiement $paiement): void
    {
        //
    }

    /**
     * Handle the Paiement "force deleted" event.
     */
    public function forceDeleted(Paiement $paiement): void
    {
        //
    }
}

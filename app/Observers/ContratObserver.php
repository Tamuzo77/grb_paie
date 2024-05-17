<?php

namespace App\Observers;

use App\Models\Contrat;
use App\Services\ItsService;

class ContratObserver
{
    /**
     * Handle the Contrat "created" event.
     */
    public function created(Contrat $contrat): void
    {
        $contratO = Contrat::find($contrat->id);
        $contratO->tauxIts = ItsService::getIts($contrat->salaire_brut);
        $contratO->save();
    }

    /**
     * Handle the Contrat "updated" event.
     */
    public function updated(Contrat $contrat): void
    {
        $contratO = Contrat::find($contrat->id);
        $contratO->tauxIts = ItsService::getIts($contrat->salaire_brut);
        $contratO->save();
    }

    /**
     * Handle the Contrat "deleted" event.
     */
    public function deleted(Contrat $contrat): void
    {
        //
    }

    /**
     * Handle the Contrat "restored" event.
     */
    public function restored(Contrat $contrat): void
    {
        //
    }

    /**
     * Handle the Contrat "force deleted" event.
     */
    public function forceDeleted(Contrat $contrat): void
    {
        //
    }
}

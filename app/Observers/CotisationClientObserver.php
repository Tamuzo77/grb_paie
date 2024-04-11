<?php

namespace App\Observers;

use App\Models\CotisationClient;

class CotisationClientObserver
{
    /**
     * Handle the CotisationClient "created" event.
     */
    public function created(CotisationClient $cotisationClient): void
    {
        //
    }

    /**
     * Handle the CotisationClient "updated" event.
     */
    public function updated(CotisationClient $cotisationClient): void
    {
        $trimestre1 = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Trimestre 1')
            ->first();
        $janvier = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Janvier')
            ->first();
        $fevrier = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Fevrier')
            ->first();
        $mars = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Mars')
            ->first();
        $trimestre1->update([
            'somme_salaires_bruts' => $janvier->somme_salaires_bruts + $fevrier->somme_salaires_bruts + $mars->somme_salaires_bruts,
            'somme_cotisations' => $janvier->somme_cotisations + $fevrier->somme_cotisations + $mars->somme_cotisations,
        ]);
        $trimestre2 = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Trimestre 2')
            ->first();
        $avril = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Avril')
            ->first();
        $mai = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Mai')
            ->first();
        $juin = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Juin')
            ->first();
        $trimestre2->update([
            'somme_salaires_bruts' => $avril->somme_salaires_bruts + $mai->somme_salaires_bruts + $juin->somme_salaires_bruts,
            'somme_cotisations' => $avril->somme_cotisations + $mai->somme_cotisations + $juin->somme_cotisations,
        ]);
        $trimestre3 = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Trimestre 3')
            ->first();
        $juillet = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Juillet')
            ->first();
        $aout = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Aout')
            ->first();
        $septembre = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Septembre')
            ->first();
        $trimestre3->update([
            'somme_salaires_bruts' => $juillet->somme_salaires_bruts + $aout->somme_salaires_bruts + $septembre->somme_salaires_bruts,
            'somme_cotisations' => $juillet->somme_cotisations + $aout->somme_cotisations + $septembre->somme_cotisations,
        ]);
        $trimestre4 = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Trimestre 4')
            ->first();
        $octobre = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Octobre')
            ->first();
        $novembre = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Novembre')
            ->first();
        $decembre = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Decembre')
            ->first();
        $trimestre4->update([
            'somme_salaires_bruts' => $octobre->somme_salaires_bruts + $novembre->somme_salaires_bruts + $decembre->somme_salaires_bruts,
            'somme_cotisations' => $octobre->somme_cotisations + $novembre->somme_cotisations + $decembre->somme_cotisations,
        ]);
        $total = CotisationClient::where('client_id', $cotisationClient->client_id)
            ->where('annee_id', $cotisationClient->annee_id)
            ->where('agent', 'Total')
            ->first();
        $total->update([
            'somme_salaires_bruts' => $trimestre1->somme_salaires_bruts + $trimestre2->somme_salaires_bruts + $trimestre3->somme_salaires_bruts + $trimestre4->somme_salaires_bruts,
            'somme_cotisations' => $trimestre1->somme_cotisations + $trimestre2->somme_cotisations + $trimestre3->somme_cotisations + $trimestre4->somme_cotisations,
        ]);
    }

    /**
     * Handle the CotisationClient "deleted" event.
     */
    public function deleted(CotisationClient $cotisationClient): void
    {
        //
    }

    /**
     * Handle the CotisationClient "restored" event.
     */
    public function restored(CotisationClient $cotisationClient): void
    {
        //
    }

    /**
     * Handle the CotisationClient "force deleted" event.
     */
    public function forceDeleted(CotisationClient $cotisationClient): void
    {
        //
    }
}

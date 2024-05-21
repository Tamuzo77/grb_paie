<?php

namespace App\Actions;

use App\Models\Contrat;
use App\Models\TypePaiement;
use DateTime;

class CalculerSalaireMensuel
{
    public function handle(Contrat $employee)
    {
        $tauxCnss = $employee->client->tauxCnss ?? 0.036;
        $salaire = $employee->salaire_brut * (1 - $employee->tauxIts - $tauxCnss);
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $startDate = new DateTime($absence->date_debut);
            $endDate = new DateTime($absence->date_fin);
            $nb_jours_absences += date_diff($startDate, $endDate)->days;
        }
        $nb_jours_travaille = 20 - $nb_jours_absences;
        $result = $salaire * $nb_jours_travaille / 20;
        $soustraire = 0;
        foreach ($employee->misAPieds as $misAPied) {
            $soustraire += $misAPied->montant * $misAPied->nbre_jours;
        }
        $result -= $soustraire;
        foreach ($employee->primes as $prime) {
            $date = new DateTime($prime->date);
            if ($date->format('m') == now()->format('m')) {
                $result += $prime->montant;
            }
        }

        return $result;
    }

    public static function nbreJoursTravaille(\App\Models\Contrat $employee)
    {
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $startDate = new DateTime($absence->date_debut);
            $endDate = new DateTime($absence->date_fin);
            $nb_jours_absences += date_diff($startDate, $endDate)->days;
        }

        return 20 - $nb_jours_absences;

    }

    public static function sommePrets(Contrat $employee)
    {
        $montant = 0;
        $result = Contrat::query()
            ->selectRaw('MONTHNAME(paiements.date_paiement) AS mois, SUM(paiements.solde) AS total, SUM(paiements.pas) AS pas, SUM(paiements.reste) AS reste')
            ->join('paiements', 'contrats.id', '=', 'paiements.contrat_id')
            ->where('contrats.id', $employee->id)
            ->where('paiements.type_paiement_id', TypePaiement::PRET)
            ->whereBetween('paiements.date_paiement', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy(['mois'])
            ->get();
        if ($result->sum('reste') == 0 || $result->sum('reste') == null) {
            $pas = $result->sum('pas') ?? 1;
            if ($pas == 0 || $pas == null) {
                $pas = 1;
            }
            $montant = $result->sum('total') / $pas;
        } else {
            $pas = $result->sum('pas') ?? 1;
            if ($pas == 0 || $pas == null) {
                $pas = 1;
            }
            $montant = $result->sum('reste') / $pas;

        }

        return $montant;

    }
}

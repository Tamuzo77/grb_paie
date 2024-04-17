<?php

namespace App\Actions;

use App\Models\Employee;
use App\Models\TypePaiement;
use DateTime;

class CalculerSalaireMensuel
{
    public function handle(Employee $employee)
    {
        $tauxCnss = $employee->tauxCnss ?? 0.036;
        $salaire = $employee->salaire * (1 - $employee->tauxIts - $tauxCnss);
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $startDate = new DateTime($absence->date_debut);
            $endDate = new DateTime($absence->date_fin);
            $nb_jours_absences += date_diff($startDate, $endDate)->days;
        }
        $nb_jours_travaille = 20 - $nb_jours_absences;

        $result = $salaire * $nb_jours_travaille / 20;
        $employee->misAPieds->each(function ($misAPied) use ($result) {
            $result -= $misAPied->montant;
        });

        return $result;
    }

    public static function nbreJoursTravaille(\App\Models\Employee $employee)
    {
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $startDate = new DateTime($absence->date_debut);
            $endDate = new DateTime($absence->date_fin);
            $nb_jours_absences += date_diff($startDate, $endDate)->days;
        }
        return 20 - $nb_jours_absences;

    }

    public static function sommePrets(Employee $employee)
    {
        $montant = 0;
        $result = Employee::query()
            ->selectRaw('MONTHNAME(paiements.date_paiement) AS mois, SUM(paiements.solde) AS total, SUM(paiements.pas) AS pas, SUM(paiements.reste) AS reste')
            ->join('paiements', 'employees.id', '=', 'paiements.employee_id')
            ->where('employees.id', $employee->id)
            ->where('paiements.type_paiement_id', TypePaiement::PRET)
            ->whereBetween('paiements.date_paiement', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy(['mois'])
            ->get();
        if ($result->sum('reste') == 0 || $result->sum('reste') == null) {
            $pas = $result->sum('pas') ?? 1;
            if ($pas == 0 || $pas == null)
                $pas = 1;
            $montant = $result->sum('total') / $pas;
        }else{
            $pas = $result->sum('pas') ?? 1;
            if ($pas == 0 || $pas == null)
                $pas = 1;
            $montant = $result->sum('reste') / $pas ;

        }
        return $montant;

    }
}

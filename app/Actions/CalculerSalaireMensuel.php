<?php

namespace App\Actions;

use App\Models\Employee;
use App\Models\TypePaiement;

class CalculerSalaireMensuel
{
    public function handle(Employee $employee)
    {
        $tauxCnss = $employee->tauxCnss ?? 0.036;
        $salaire = $employee->salaire * (1 - $employee->tauxIts - $tauxCnss);
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $nb_jours_absences += date_diff($absence->date_debut, $absence->date_fin)->days;
        }
        $nb_jours_travaille = 20 - $nb_jours_absences;

        $result = $salaire * $nb_jours_travaille / 20;

        return $result;
    }

    public static function nbreJoursTravaille(\App\Models\Employee $employee)
    {
        $nb_jours_absences = 0;
        foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
            $nb_jours_absences += date_diff($absence->date_debut, $absence->date_fin)->days;
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
            $montant = $result->sum('total') / $result->sum('pas');
        }else{
            $montant = $result->sum('reste') / $result->sum('pas');

        }
        $montant = $result->sum('total') / $result->sum('pas');
        return $montant;

    }
}

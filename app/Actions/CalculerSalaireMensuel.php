<?php

namespace App\Actions;

use App\Models\Employee;

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
}

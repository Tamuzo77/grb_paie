<?php

function nbreJoursTravaille(\App\Models\Employee $employee)
{
    $nb_jours_absences = 0;
    foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
        $nb_jours_absences += date_diff($absence->date_debut, $absence->date_fin)->days;
    }
    return 20 - $nb_jours_absences;

}

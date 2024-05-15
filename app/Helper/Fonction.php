<?php

use App\Models\Annee;

function nbreJoursTravaille(\App\Models\Employee $employee)
{
    $nb_jours_absences = 0;
    foreach ($employee->absences()->where('date_debut', '>=', now()->startOfMonth())->whereDeductible(true)->get() as $absence) {
        $nb_jours_absences += date_diff($absence->date_debut, $absence->date_fin)->days;
    }

    return 20 - $nb_jours_absences;

}
function convertir_en_lettres($nombre)
{
    $f = new NumberFormatter('fr', NumberFormatter::SPELLOUT);

    return $f->format($nombre);
}

function getAnnee()
{
    if (session()->has('ANNEE_ID')) {
        $annee = Annee::find(session()->get('ANNEE_ID'));
    } else {
        $annee = Annee::latest()->first();
        session()->put('ANNEE_ID', $annee ? $annee->id : null);
    }
    return $annee;
}

function getLastAnnee()
{
    $annee = Annee::latest()->first();
    return $annee;
}

function archive()
{
    $annees = Annee::where('id', '<>', getLastAnnee()->id)->orderBy('nom', 'desc')->get();
    return $annees;
}

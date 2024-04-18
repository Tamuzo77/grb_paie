<?php

namespace App\Exports;

use AllowDynamicProperties;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class SoldesExport implements FromView
{
    public function __construct($soldes)
    {
        $this->soldes = $soldes;
    }

    #[\Override]
    public function view(): View
    {
        $salaireMensuel = $this->soldes[0]->montant;
        $treiziemeMois = $this->soldes[1]->montant;
        $nbJoursCongesPayes = $this->soldes[2]->montant;
        $preavis = $this->soldes[3]->montant;
        $avances = $this->soldes[4]->montant;
        $prets = $this->soldes[5]->montant;
        $total = $this->soldes[6]->montant;
        $employe = $this->soldes[0]->employee;

        return view('exports.solde-employe', [
            'salaireMensuel' => $salaireMensuel,
            'treiziemeMois' => $treiziemeMois,
            'nbJoursCongesPayes' => $nbJoursCongesPayes,
            'preavis' => $preavis,
            'avances' => $avances,
            'prets' => $prets,
            'total' => $total,
            'employe' => $employe,
        ]);
    }
}

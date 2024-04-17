<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Models\Annee;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

#[AllowDynamicProperties] class BilanAnnuelExport implements FromView
{
    public function __construct(Annee $annee)
    {
        $this->annee = $annee;
    }

    public function view(): View
    {
        $employees = Employee::where('annee_id', $this->annee->id)->with(['soldeComptes', 'demandeConges', 'misAPieds'])->get();

        return view('exports.bilan-annuel', [
            'annee' => $this->annee,
        ]);
    }
}

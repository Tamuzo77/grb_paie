<?php

namespace App\Http\Controllers;

use App\Exports\CotisationEmployeExport;
use App\Exports\EtatPersonnelExport;
use App\Exports\FichePaieExport;
use App\Exports\SoldesExport;
use App\Models\Client;
use App\Models\CotisationEmploye;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{


    public function downloadEtatsPersonnel($id)
    {
        $client = Client::find($id);

            $export = new EtatPersonnelExport($client);

            return Excel::download($export, "etat-personnel-{$client->nom}.xlsx");


    }

    public function downloadFicheDePaie($id)
    {
        $paiement = Paiement::find($id);
        $export = new FichePaieExport($paiement);
        $excel = Excel::download($export, "fiche-de-paie-{$paiement->employee->nom}.xlsx");
        return $excel;
    }

    public function downloadSoldes($records)
    {
        $recordIds = explode(',', $records);
        $records = SoldeCompte::whereIn('id', $recordIds)->get();
        $export = new SoldesExport($records);
        return Excel::download($export, 'soldes.xlsx');
    }

    public function downloadCotisationsEmployes($records)
    {
        $recordIds = explode(',', $records);
        $records = CotisationEmploye::whereIn('id', $recordIds)->get();
        $export = new CotisationEmployeExport($records);
        return Excel::download($export, 'cotisations-employes.xlsx');
    }
}

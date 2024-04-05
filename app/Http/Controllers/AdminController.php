<?php

namespace App\Http\Controllers;

use App\Exports\EtatPersonnelExport;
use App\Exports\FichePaieExport;
use App\Models\Client;
use App\Models\Paiement;
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
}

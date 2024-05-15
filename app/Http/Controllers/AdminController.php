<?php

namespace App\Http\Controllers;

use App\Exports\BilanAnnuelExport;
use App\Exports\CotisationClientExport;
use App\Exports\CotisationEmployeExport;
use App\Exports\DetailsFacturationExport;
use App\Exports\EtatPersonnelExport;
use App\Exports\FichePaieExport;
use App\Exports\SoldesExport;
use App\Models\Annee;
use App\Models\Client;
use App\Models\CotisationClient;
use App\Models\CotisationEmploye;
use App\Models\Employee;
use App\Models\Facturation;
use App\Models\Paiement;
use App\Models\SoldeCompte;
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
        $preferences = request()->query('preferences');


        $paiement = Paiement::find($id);
        $export = new FichePaieExport($paiement, $preferences);
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

    public function downloadCotisationsClients($records)
    {
        $recordIds = explode(',', $records);
        $records = CotisationClient::whereIn('id', $recordIds)->get();
        $export = new CotisationClientExport($records);

        return Excel::download($export, 'cotisations-employes.xlsx');
    }

    public function downloadBilanAnnuel($record)
    {
        $annee = Annee::find($record);
        $export = new BilanAnnuelExport($annee);

        return Excel::download($export, 'bilan-annuel.xlsx');
        //        $employees = Employee::where('annee_id', $annee->id)->with(['soldeComptes', 'demandeConges', 'misAPieds'])->get();
        //
        //
        //        return view('exports.bilan-annuel', [
        //            'annee' => $annee,
        //            'employees' => $employees,
        //        ]);
    }

    public function downloadDetailsFacturation($record)
    {
        $facturation = Facturation::find($record);
        $export = new DetailsFacturationExport($facturation);

        return Excel::download($export, 'details-facturation.xlsx');
    }
}

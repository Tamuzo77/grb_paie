<?php

namespace App\Http\Controllers;

use App\Exports\EtatPersonnelExport;
use App\Models\Client;
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
}

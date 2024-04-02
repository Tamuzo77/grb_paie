<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class EtatController extends Controller
{
    //
    public function etat()
    {
        //
        return Inertia::render('Paiement/Etat');
    }
}

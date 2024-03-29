<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class EtatController extends Controller
{
    //
    public function etat()
    {
        //
        return Inertia::render('Paiement/Etat');
    }

}

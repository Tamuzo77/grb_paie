<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    public function index()
    {
        
        $user = auth()->user();
        
        // Vérifier si l'utilisateur a configuré un code de vérification à deux facteurs
        if (!$user->hasTwoFactorCode()) {
             return inertia('/Dashboard');
        }
    
        return inertia('Auth/twofactor', [
            'status' => session('status'),
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => ['integer', 'required'],
        ]);

        $user = auth()->user();

        if ($request->input('two_factor_code') !== $user->two_factor_code) {
            // Incrémenter le nombre de tentatives dans la session
            $attempts = Session::get('verification_attempts', 0);
            Session::put('verification_attempts', $attempts + 1);

            // Vérifier si le nombre de tentatives atteint 3
            if ($attempts >= 2) {
                // Bloquer l'utilisateur
                $user->blocked = true;
                $user->save();
                // Déconnecter l'utilisateur
                auth()->logout();

                // Rediriger vers la page de connexion avec un message d'erreur
                return redirect()->route('login')->with('status', 'Trop de tentatives. Votre compte a été bloqué. Veuillez contacter l\'administrateur.');
            }


            return redirect()->back()->with('status', 'Code non valide');
        }

        $user->resetTwoFactorCode();

        // Réinitialiser le nombre de tentatives après une connexion réussie
        Session::forget('verification_attempts');

//        if (auth()->user()->login_count == 1)
//        {
            return redirect(RouteServiceProvider::HOME);
//        }
//        else{
//            return redirect(RouteServiceProvider::ADMIN);
//        }


    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new SendTwoFactorCode());
        return back()->withStatus(__('Le code a été renvoyé.'));
    }
}

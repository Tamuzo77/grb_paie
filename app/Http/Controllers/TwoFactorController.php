<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    public function index()
    {
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
            return \redirect()->back()->with('status', 'Code non valide');       }

        $user->resetTwoFactorCode();


        return redirect(RouteServiceProvider::ADMIN);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new SendTwoFactorCode());
        return back()->withStatus(__('Code has been sent again'));
    }
}

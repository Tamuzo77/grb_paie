<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('auth');

Route::get('/dashboard', function () {
    if (auth()->user()->login_count == 1) {
        return redirect()->route('first');
    }
    return Inertia::render('Dashboard');
})->middleware(['auth', 'twofactor',])->name('dashboard');
Route::get('/first', function () {
    $user = auth()->user();
    return Inertia::render('Auth/FirstLogin', [
        'user' => $user
    ]);
})->middleware(['auth', 'twofactor',])->name('first');
Route::middleware('auth')->group(function () {
    Route::resource('/client', ClientController::class);
    Route::get('fichepaie', [FicheController::class, 'index']);
    Route::get('etat', [EtatController::class, 'etat']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', 'twofactor'])->group(function () {
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
});

Route::get('/download-etats-personnel/{id}', [AdminController::class, 'downloadEtatsPersonnel'])->name('download-etats-personnel');
Route::get('/download-fiche-de-paie/{id}', [AdminController::class, 'downloadFicheDePaie'])->name('download-fiche-de-paie');
require __DIR__ . '/auth.php';

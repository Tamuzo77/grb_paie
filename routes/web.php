<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\ProfileController;
use App\Mail\VerificationCodeEmail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
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
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/client', ClientController::class);
    Route::get('fichepaie', [FicheController::class, 'index']);
    Route::get('etat', [EtatController::class, 'etat']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/testroute', function () {
    $name = 'Funny Coder';

    // The email sending is done using the to method on the Mail facade
    Mail::to('esperanceahouissou@gmail.com')->send(new VerificationCodeEmail($name));

});

require __DIR__.'/auth.php';

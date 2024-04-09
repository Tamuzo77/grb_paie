<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Paiement;
use App\Models\SoldeCompte;
use App\Observers\EmployeeObserver;
use App\Observers\PaiementObserver;
use App\Observers\SoldeCompteObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paiement::observe(PaiementObserver::class);
        SoldeCompte::observe(SoldeCompteObserver::class);
        Employee::observe(EmployeeObserver::class);
    }
}

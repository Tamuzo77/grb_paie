<?php

namespace App\Observers;

use App\Models\Annee;
use App\Models\Employee;
use App\Services\ItsService;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        $employee->annee_id = Annee::latest()->first()->id;
                $employee->tauxIts = ItsService::getIts($employee->salaire_brut);
        $employee->save();
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        //        $employee->update([
        //            'annee_id' => Annee::latest()->first()->id,
        //            'tauxIts' => ItsService::getIts($employee->salaire),
        //        ]);
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "restored" event.
     */
    public function restored(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee): void
    {
        //
    }
}

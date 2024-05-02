<?php

namespace App\Filament\Resources\PrimeResource\Pages;

use App\Filament\Resources\PrimeResource;
use App\Models\Employee;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePrime extends CreateRecord
{
    protected static string $resource = PrimeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $employee = Employee::find($data['employee_id']);
        $data['nom'] = "Prime de {$data['montant']} FCFA";

        return parent::mutateFormDataBeforeCreate($data);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Prime enregistrée avec succès');
    }
}

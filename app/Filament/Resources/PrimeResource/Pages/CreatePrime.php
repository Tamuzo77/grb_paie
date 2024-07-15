<?php

namespace App\Filament\Resources\PrimeResource\Pages;

use App\Filament\Resources\PrimeResource;
use App\Models\Employee;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Contrat;
class CreatePrime extends CreateRecord
{
    protected static string $resource = PrimeResource::class;
         protected function mutateFormDataBeforeCreate(array $data): array
         {
            $employee = Contrat::find($data['contrat_id'])->employee;
             $data['nom'] = "Prime de {$data['montant']} FCFA";

             return parent::mutateFormDataBeforeCreate($data);
         }
    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Prime enregistrée avec succès');
    }
}

<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Annee;
use App\Services\ItsService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
//        $data['tauxIts'] = ItsService::getIts($data['salaire']);
        $annee = Annee::latest()->first()->get();
        $data['annee_id'] = $annee[0]['id'] ?? 1;

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Employé crée avec succès');
    }
}

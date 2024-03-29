<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Annee;
use App\Services\ItsService;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tauxIts'] = ItsService::getIts($data['salaire']);
        $data['annee_id'] = Annee::latest()->get('id');

        return $data;
    }
}

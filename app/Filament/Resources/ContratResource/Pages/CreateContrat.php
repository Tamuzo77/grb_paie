<?php

namespace App\Filament\Resources\ContratResource\Pages;

use App\Filament\Resources\ContratResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContrat extends CreateRecord
{
    protected static string $resource = ContratResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['annee_id'] = getAnnee()->id;
        return $data;
    }
}

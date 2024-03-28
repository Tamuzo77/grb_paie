<?php

namespace App\Filament\Clusters\Settings\Resources\AnneeResource\Pages;

use App\Filament\Clusters\Settings\Resources\AnneeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnee extends CreateRecord
{
    protected static string $resource = AnneeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
         $data['nom'] = date('Y', $data['debut']) . ' - ' . date('Y', $data['fin']);
         return $data;
    }
}

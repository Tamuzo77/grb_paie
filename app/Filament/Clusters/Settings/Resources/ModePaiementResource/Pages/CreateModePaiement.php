<?php

namespace App\Filament\Clusters\Settings\Resources\ModePaiementResource\Pages;

use App\Actions\GenereCode;
use App\Filament\Clusters\Settings\Resources\ModePaiementResource;
use App\Models\ModePaiement;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateModePaiement extends CreateRecord
{
    protected static string $resource = ModePaiementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = (new GenereCode())->handle(ModePaiement::class, 'MP');
        return $data;
    }
}

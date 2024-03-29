<?php

namespace App\Filament\Clusters\Settings\Resources\TypePaiementResource\Pages;

use App\Actions\GenereCode;
use App\Filament\Clusters\Settings\Resources\TypePaiementResource;
use App\Models\ModePaiement;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypePaiement extends CreateRecord
{
    protected static string $resource = TypePaiementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = (new GenereCode())->handle(ModePaiement::class, 'MP');
        return $data;
    }
}

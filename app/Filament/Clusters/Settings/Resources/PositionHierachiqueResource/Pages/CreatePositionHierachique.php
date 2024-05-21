<?php

namespace App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource\Pages;

use App\Actions\GenereCode;
use App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource;
use App\Models\PositionHierachique;
use Filament\Resources\Pages\CreateRecord;

class CreatePositionHierachique extends CreateRecord
{
    protected static string $resource = PositionHierachiqueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = (new GenereCode())->handle(PositionHierachique::class, 'PH');

        return $data;
    }
}

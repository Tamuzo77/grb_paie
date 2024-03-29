<?php

namespace App\Filament\Clusters\Settings\Resources\ModePaiementResource\Pages;

use App\Filament\Clusters\Settings\Resources\ModePaiementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModePaiement extends EditRecord
{
    protected static string $resource = ModePaiementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

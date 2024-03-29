<?php

namespace App\Filament\Clusters\Settings\Resources\TypePaiementResource\Pages;

use App\Filament\Clusters\Settings\Resources\TypePaiementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypePaiement extends EditRecord
{
    protected static string $resource = TypePaiementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

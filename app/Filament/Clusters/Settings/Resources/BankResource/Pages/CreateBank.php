<?php

namespace App\Filament\Clusters\Settings\Resources\BankResource\Pages;

use App\Filament\Clusters\Settings\Resources\BankResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBank extends CreateRecord
{
    protected static string $resource = BankResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Banque enregistrée avec succès';
    }
}

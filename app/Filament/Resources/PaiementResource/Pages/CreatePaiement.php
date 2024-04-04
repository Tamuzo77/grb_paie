<?php

namespace App\Filament\Resources\PaiementResource\Pages;

use App\Filament\Resources\PaiementResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePaiement extends CreateRecord
{
    protected static string $resource = PaiementResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Paiement effectué avec succès');
    }
}

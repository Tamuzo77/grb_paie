<?php

namespace App\Filament\Resources\DemandeCongeResource\Pages;

use App\Filament\Resources\DemandeCongeResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDemandeConge extends CreateRecord
{
    protected static string $resource = DemandeCongeResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Demande de congés effectué avec succès');
    }
}

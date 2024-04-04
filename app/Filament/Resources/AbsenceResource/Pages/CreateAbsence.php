<?php

namespace App\Filament\Resources\AbsenceResource\Pages;

use App\Filament\Resources\AbsenceResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsence extends CreateRecord
{
    protected static string $resource = AbsenceResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Absence enregistré avec succès');
    }
}

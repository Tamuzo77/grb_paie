<?php

namespace App\Filament\Clusters\Settings\Resources\FonctionResource\Pages;

use App\Filament\Clusters\Settings\Resources\FonctionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFonction extends CreateRecord
{
    protected static string $resource = FonctionResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Fonction enregistrée avec succès';
    }
}

<?php

namespace App\Filament\Clusters\Settings\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Settings\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Catégorie enregistrée avec succès';
    }
}

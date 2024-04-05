<?php

namespace App\Filament\Clusters\Settings\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Settings\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public static function shouldRegisterSpotlight(): bool
    {
        return false;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Catégorie modifiée avec succès';
    }
}

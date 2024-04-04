<?php

namespace App\Filament\Clusters\Settings\Resources\FonctionResource\Pages;

use App\Filament\Clusters\Settings\Resources\FonctionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFonction extends EditRecord
{
    protected static string $resource = FonctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Fonction modifiée avec succès';
    }
}

<?php

namespace App\Filament\Resources\DemandeCongeResource\Pages;

use App\Filament\Resources\DemandeCongeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemandeConge extends EditRecord
{
    protected static string $resource = DemandeCongeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Demande de congés modifié avec succès';
    }
}

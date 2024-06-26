<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Annee;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $annee = Annee::latest()->first()->get();
        $data['annee_id'] = $annee[0]['id'] ?? 1;

        $data['prenom_donneur_ordre'] = $data['prenom_donneur_ordre'] ?? $data['nom_donneur_ordre'];

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Client crée avec succès');
    }

    protected function getRedirectUrl(): string
    {
        return self::$resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
    }
}

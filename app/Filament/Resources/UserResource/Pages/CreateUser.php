<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make('Grb@2024?');

        return $data;
    }

    protected ?string $heading = 'Ajouter un utilisateur';

    public function getBreadcrumb(): string
    {
        return 'Enregistrement';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()->label('Créer');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->label('Créer un autre');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return parent::getCreatedNotification()->title('Utilisateur crée avec succès');
    }
}

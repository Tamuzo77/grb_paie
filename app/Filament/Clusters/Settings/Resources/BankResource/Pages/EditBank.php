<?php

namespace App\Filament\Clusters\Settings\Resources\BankResource\Pages;

use App\Filament\Clusters\Settings\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBank extends EditRecord
{
    protected static string $resource = BankResource::class;

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
        return 'Banque modifiée avec succès';
    }
}

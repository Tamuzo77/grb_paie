<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

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
        return 'Employé modifié avec succès';
    }
}

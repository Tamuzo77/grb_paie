<?php

namespace App\Filament\Clusters\Settings\Resources\AnneeResource\Pages;

use App\Filament\Clusters\Settings\Resources\AnneeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnee extends EditRecord
{
    protected static string $resource = AnneeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

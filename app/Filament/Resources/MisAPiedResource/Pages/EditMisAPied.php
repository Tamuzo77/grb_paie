<?php

namespace App\Filament\Resources\MisAPiedResource\Pages;

use App\Filament\Resources\MisAPiedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMisAPied extends EditRecord
{
    protected static string $resource = MisAPiedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

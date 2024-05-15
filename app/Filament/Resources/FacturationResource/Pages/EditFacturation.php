<?php

namespace App\Filament\Resources\FacturationResource\Pages;

use App\Filament\Resources\FacturationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFacturation extends EditRecord
{
    protected static string $resource = FacturationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

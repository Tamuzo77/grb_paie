<?php

namespace App\Filament\Resources\MisAPiedResource\Pages;

use App\Filament\Resources\MisAPiedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMisAPieds extends ListRecords
{
    protected static string $resource = MisAPiedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

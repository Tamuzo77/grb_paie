<?php

namespace App\Filament\Resources\DemandeCongeResource\Pages;

use App\Filament\Resources\DemandeCongeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemandeConges extends ListRecords
{
    protected static string $resource = DemandeCongeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

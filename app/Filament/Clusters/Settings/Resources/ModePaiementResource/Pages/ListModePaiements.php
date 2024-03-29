<?php

namespace App\Filament\Clusters\Settings\Resources\ModePaiementResource\Pages;

use App\Filament\Clusters\Settings\Resources\ModePaiementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModePaiements extends ListRecords
{
    protected static string $resource = ModePaiementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

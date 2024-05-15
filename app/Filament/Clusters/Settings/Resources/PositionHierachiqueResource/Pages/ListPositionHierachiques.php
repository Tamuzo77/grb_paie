<?php

namespace App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource\Pages;

use App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPositionHierachiques extends ListRecords
{
    protected static string $resource = PositionHierachiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

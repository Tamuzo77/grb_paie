<?php

namespace App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource\Pages;

use App\Filament\Clusters\Settings\Resources\PositionHierachiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPositionHierachique extends EditRecord
{
    protected static string $resource = PositionHierachiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

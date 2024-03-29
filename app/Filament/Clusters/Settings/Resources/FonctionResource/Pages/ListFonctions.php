<?php

namespace App\Filament\Clusters\Settings\Resources\FonctionResource\Pages;

use App\Filament\Clusters\Settings\Resources\FonctionResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListFonctions extends ListRecords
{
    protected static string $resource = FonctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->form([
                    TextInput::make('nom')
                        ->required()
                        ->maxLength(255),
                ]),
        ];
    }
}

<?php

namespace App\Filament\Resources\PrimeResource\Pages;

use App\Filament\Resources\PrimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrimes extends ListRecords
{
    protected static string $resource = PrimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Settings\Resources\BankResource\Pages;

use App\Filament\Clusters\Settings\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanks extends ListRecords
{
    protected static string $resource = BankResource::class;

    protected static ?string $title = 'Liste des banques';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

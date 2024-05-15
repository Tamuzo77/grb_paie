<?php

namespace App\Filament\Resources\FacturationResource\Pages;

use App\Filament\Resources\FacturationResource;
use App\Models\Contrat;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacturations extends ListRecords
{
    protected static string $resource = FacturationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['total_salaire_brut'] = 0;
                    $data['montant_facture'] = 0;
                    $data['taux'] = 0;
                    $data['montant_facture'] = $data['total_salaire_brut'] * $data['taux'] / 100;
                    return $data;
                }),
        ];
    }
}

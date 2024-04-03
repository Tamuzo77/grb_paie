<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un utilisateur'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous les utilisateurs'),
            'directeurs operationnels' => Tab::make('Directeurs Opérationnels')
            ->modifyQueryUsing(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'directrice_opérationnelle');
                });
            }),
            'responsables commerciaux' => Tab::make('Responsables Commerciaux')
            ->modifyQueryUsing(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'responsable_commercial');
                });
            }),
        ];
    }
}

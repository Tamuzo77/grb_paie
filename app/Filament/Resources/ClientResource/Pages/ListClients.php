<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Annee;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class ListClients extends ListRecords
{
    use InteractsWithPageFilters;
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
//    protected function modifyQueryWithActiveTab(Builder $query): Builder
//    {
//        $annee = Annee::whereSlug($this->filters['annee_id'] ?? now()->year)->firstOrFail();
//        return $query->where('annee_id', $annee->id);
//    }
}

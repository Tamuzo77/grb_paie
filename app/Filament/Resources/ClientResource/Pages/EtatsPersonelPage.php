<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Client;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ManageRecords;

class EtatsPersonelPage extends ManageRecords
{
    use InteractsWithRecord;

    protected static string $resource = EmployeeResource::class;

    protected static string $view = 'filament.resources.client-resource.pages.etats-personel';

    protected ?string $heading = 'Etats du personnel';

    public function mount(): void
    {
        $this->record = Client::whereSlug($this->record)->firstOrFail();

    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous les employés')
                ->modifyQueryUsing(function ($query) {
                    $query->where('client_id', $this->record);
                }),
        ];
    }

    public function getBreadcrumb(): ?string
    {
        return 'Etats du personnel';
    }

    /**
     * @return string|null
     */
    /**
     * @return string|null
     */
}

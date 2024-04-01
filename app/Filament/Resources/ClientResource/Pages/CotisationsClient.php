<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class CotisationsClient extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ClientResource::class;

    protected static string $view = 'filament.resources.client-resource.pages.cotisations-client';

    public function getTitle(): string|Htmlable
    {
        return 'Cotisations du client '.$this->record->nom;
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    //    public function form(Form $form): Form
    //    {
    //        return $form
    //            ->schema([
    //                $this->getGeneralSection(),
    //            ])
    //            ->model($this->record)
    //            ->live();
    //    }

    protected function getGeneralSection(): Component
    {
        return Section::make('head')
            ->schema([
                TextInput::make('number_prefix')
                    ->nullable(),
            ]);

    }
}

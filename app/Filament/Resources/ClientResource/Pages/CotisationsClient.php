<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Client;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\HasTabs;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class CotisationsClient extends Page
{
    use InteractsWithRecord;
    protected static string $resource = ClientResource::class;

    protected static string $view = 'filament.resources.client-resource.pages.cotisations-client';



    public function getTitle(): string|Htmlable
    {
        return "Cotisations du client " . $this->record->nom;
    }

    public function mount(int | string $record): void
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





    protected function getGeneralSection() : Component
    {
        return Section::make('head')
            ->schema([
                TextInput::make('number_prefix')
                    ->nullable(),
            ]);

    }

}

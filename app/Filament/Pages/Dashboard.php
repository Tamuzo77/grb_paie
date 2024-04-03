<?php

namespace App\Filament\Pages;

use App\Models\Annee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;


    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('annee_id')
                            ->label('Année')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(3)
                            ->default(Annee::latest()->first()?->slug)
                            ->options(fn()=> Annee::pluck('nom', 'slug'))
                    ]),
            ])
            ->columns(4);
    }



}

<?php

namespace App\Filament\Pages;

use App\Models\Annee;
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
                            ->columnSpan(1)
                            ->label('Année d\'exercice')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(3)
                            ->default(Annee::latest()->first()?->slug)
                            ->options(fn () => Annee::pluck('nom', 'slug')),
                    ])
                    ->columnSpan(2),
                Section::make()
                    ->columnSpan(2)
                    ->schema([
                        // Add more filters here
                        Select::make('mois')
                            ->label('Mois')
                            ->options([
                                '01' => 'Janvier',
                                '02' => 'Février',
                                '03' => 'Mars',
                                '04' => 'Avril',
                                '05' => 'Mai',
                                '06' => 'Juin',
                                '07' => 'Juillet',
                                '08' => 'Août',
                                '09' => 'Septembre',
                                '10' => 'Octobre',
                                '11' => 'Novembre',
                                '12' => 'Décembre',
                            ]),
                    ]),

            ])
            ->columns(4);
    }
}

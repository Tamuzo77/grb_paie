<?php

namespace App\Livewire;

use App\Models\Annee;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class GlobalFilter extends Component implements HasForms
{
    use HasTabs, InteractsWithForms, HasFiltersForm;

    public function table(Table $table): Table
    {
        return $table
            ->query(Annee::query())
            ->paginated(false)
            ->columns([
                SelectColumn::make('annee_id')
                    ->label('Année d\'exercice')
                    ->options(fn() => Annee::pluck('nom', 'slug'))
                    ->default(Annee::latest()->first()?->slug),

            ])
            ->filters([
                SelectFilter::make('annee_id')
                    ->label('Année d\'exercice')
                    ->options(fn() => Annee::pluck('nom', 'slug'))
                    ->default(Annee::latest()->first()?->slug),

            ]);
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()
                    ->extraAttributes(['class' => 'border-none'])
                    ->schema([
                        Select::make('annee_id')
                            ->label('Année d\'exercice')
                            ->live()
                            ->inlineLabel()
                            ->options(fn() => Annee::pluck('nom', 'id'))
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->suffixIcon('heroicon-o-calendar')
                            ->dehydrated()
                            ->default(getAnnee()->id)
                            ->afterStateUpdated(function ($state) {
                                session()->put('ANNEE_ID', $state);
                            }),
                    ])
                    ->columns(1)
            ])
            ->columns(1);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('annee_id')
                    ->label('Année d\'exercice')
                    ->live()
                    ->inlineLabel()
                    ->options(fn() => Annee::pluck('nom', 'id'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->suffixIcon('heroicon-o-calendar')
                    ->dehydrated()
                    ->default(getAnnee()->id)
                    ->afterStateUpdated(function ($state) {
                        session()->put('ANNEE_ID', $state['annee_id']);
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.global-filter');
    }
}

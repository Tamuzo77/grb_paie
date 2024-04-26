<?php

namespace App\Livewire;

use App\Models\Annee;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class GlobalFilter extends Component implements HasForms, HasTable
{
    use HasTabs, InteractsWithForms, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Annee::query())
            ->paginated(false)
            ->columns([
                SelectColumn::make('annee_id')
                    ->label('Année d\'exercice')
                    ->options(fn () => Annee::pluck('nom', 'slug'))
                    ->default(Annee::latest()->first()?->slug),

            ])
            ->filters([
                SelectFilter::make('annee_id')
                    ->label('Année d\'exercice')
                    ->options(fn () => Annee::pluck('nom', 'slug'))
                    ->default(Annee::latest()->first()?->slug),

            ]);
    }

    public function render()
    {
        return view('livewire.global-filter');
    }
}

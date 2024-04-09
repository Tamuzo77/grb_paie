<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\ModePaiement;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\HasTabs;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Concerns\InteractsWithRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class SalaireBulkPage extends Page implements HasForms, HasTable
{
    use HasTabs, InteractsWithForms, InteractsWithRecords, InteractsWithTable;

    protected static string $resource = EmployeeResource::class;

    protected static string $view = 'filament.resources.employee-resource.pages.salaire-bulk-page';

    public int $iteration = 0;

    public function mount()
    {
        $recordIds = explode(',', request('records'));
        $this->records = Employee::whereIn('id', $recordIds)->get();
    }

    public function getHeading(): string|Htmlable
    {
        return 'Solde des Employés selectionnés';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Détails')
                    ->description('Détails du paiements des salaires')
                    ->schema([
                        Select::make('mode_paiement_id')
                            ->searchable()
                            ->live(onBlur: true)
                            ->options(ModePaiement::query()->pluck('nom', 'id')),
                    ])
                    ->columns(1),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Employee::query();
            })
            ->columns([
                TextColumn::make('donnees')
                    ->label('Données'),
            ]);
    }
}

<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\EmployeeResource;
use App\Models\Client;
use App\Models\CotisationEmploye;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class CotisationsEmployes extends ListRecords
{
    use InteractsWithRecord;

    protected static string $resource = EmployeeResource::class;

    public function mount(): void
    {

        $this->record = Client::whereSlug($this->record)->firstOrFail();;
    }

    public function getHeading(): string
    {
        return "Cotisations des employés";
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return CotisationEmploye::query()->where('client_id', $this->record->id);
            })
            ->columns([
                TextColumn::make('agent')
                    ->label('Agent'),
                TextColumn::make('cnss')
                    ->label('CNSS'),
                TextColumn::make('its')
                    ->label('ITS'),
                TextColumn::make('total')
                    ->default(function ($record) {
                        return $record->cnss + $record->its;
                    })
                    ->label('Total'),
//                Panel::make([
//                    Split::make([
//                        TextColumn::make('telephone')
//                            ->icon('heroicon-m-phone'),
//                        TextColumn::make('email')
//                            ->icon('heroicon-m-envelope'),
//                    ])->from('md'),
//                ])->collapsible(),
            ])
            ->filters([
                SelectFilter::make('mois')
                    ->default(now()->format('F'))
                    ->options([
                        'January' => 'Janvier',
                        'Februray' => 'Février',
                        'March' => 'Mars',
                        'April' => 'Avril',
                        'May' => 'Mai',
                        'June' => 'Juin',
                        'July' => 'Juillet',
                        'August' => 'Août',
                        'September' => 'Septembre',
                        'October' => 'Octobre',
                        'November' => 'Novembre',
                        'December' => 'Décembre',
                    ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('cotisations sociales des employes '. $this->record->nom )
                            ->fromTable(),
                    ]),
            ])
            ->bulkActions([
//                ExportBulkAction::make()
//                    ->exports([
//                        ExcelExport::make()
//                            ->fromTable(),
//                    ]),
            ])
            ->selectable();
    }

    public function getBreadcrumb(): ?string
    {
        return "Cotisations des employés";
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous les employés')
        ];
    }
}

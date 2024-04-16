<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use App\Models\Client;
use App\Models\Employee;
use Filament\Tables\Table;
use App\Models\SoldeCompte;
use App\Models\CotisationEmploye;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\EmployeeResource;
use Filament\Tables\Columns\Summarizers\Sum;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use AymanAlhattami\FilamentDateScopesFilter\DateScopeFilter;

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
                    ->weight(fn($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->label('Agent'),
                TextColumn::make('cnss')
                    ->weight(fn($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr', )
//                    ->summarize(Sum::make()->money('XOF', locale: 'fr', )->label('Total'))
                    ->label('CNSS'),
                TextColumn::make('its')
                    ->weight(fn($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr', )
                    ->label('ITS'),
                TextColumn::make('total')
                    ->weight(fn($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr', )
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
                    DateScopeFilter::make('created_at')
            ])
            ->headerActions([
//                ExportAction::make()
//                    ->exports([
//                        ExcelExport::make()
//                            ->withFilename('cotisations sociales des employes '. $this->record->nom )
//                            ->fromTable(),
//                    ]),
                Action::make('export')
                    ->label('Exporter')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        try {
                            redirect(route('download-cotisations-employes',['records' => $this->getTableRecords()->pluck('id')->implode(',')]));

                            Notification::make('Etat personnel téléchargé avec succès')
                                ->title('Téléchargement réussi')
                                ->body('Le téléchargement de l\'état personnel a été effectué avec succès.')
                                ->color('success')
                                ->iconColor('success')
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make('Erreur lors du téléchargement de l\'état personnel')
                                ->title('Erreur')
                                ->body("Une erreur s'est produite lors du téléchargement de l'état personnel. Veuillez réessayer.")
                                ->color('danger')
                                ->iconColor('danger')
                                ->send();
                        }
                    })
            ])
            ->bulkActions([
//                ExportBulkAction::make()
//                    ->exports([
//                        ExcelExport::make()
//                            ->fromTable(),
//                    ]),
            ]);
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

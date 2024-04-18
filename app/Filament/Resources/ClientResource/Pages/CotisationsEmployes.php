<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use App\Models\Client;
use App\Models\Employee;
use Filament\Tables\Table;
use App\Models\SoldeCompte;
use Illuminate\Support\Carbon;
use App\Models\CotisationEmploye;
use Filament\Tables\Actions\Acti
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\EmployeeResource;
use Filament\Tables\Columns\Summarizers\Sum;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use AymanAlhattami\FilamentDateScopesFilter\DateScopeFilter;
use Filament\Forms;

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
                    ->weight(fn ($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->label('Agent'),
                TextColumn::make('cnss')
                ->visible(fn ($livewire) => $livewire->activeTab != 'its')
                    ->weight(fn ($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr',)
                    //                    ->summarize(Sum::make()->money('XOF', locale: 'fr', )->label('Total'))
                    ->label('CNSS'),
                TextColumn::make('its')
                    ->visible(fn ($livewire) => $livewire->activeTab != 'cnss')
                    ->weight(fn ($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr',)
                    ->label('ITS'),
                TextColumn::make('total')
                    ->visible(fn ($livewire) => $livewire->activeTab != 'cnss' && $livewire->activeTab != 'its')
                    ->weight(fn ($record) => $record->agent == 'Total' ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->agent == 'Total' ? TextColumn\TextColumnSize::Large : null)
                    ->money('XOF', locale: 'fr',)
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

 
                    Filter::make('created_at')
                        ->form([
                            Forms\Components\DatePicker::make('created_from')->label('Date Début'),
                            Forms\Components\DatePicker::make('created_until')->label('Date Fin'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['created_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                        })   
                        // DateScopeFilter::make('Période')

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
                            redirect(route('download-cotisations-employes', ['records' => $this->getTableRecords()->pluck('id')->implode(',')]));

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
            'cnss' => Tab::make('cnss')
            ->label('CNSS'),
            'its' => Tab::make('its')
                ->label('ITS'),
            'total' => Tab::make('total')
                ->label('TOTAL')

        ];
    }
    public function defaultTab(): ?string
    {
        return 'cnss';
    }
}

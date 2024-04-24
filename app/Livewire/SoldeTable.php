<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\SoldeCompte;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\HasTabs;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class SoldeTable extends Component implements HasForms, HasTable
{
    use HasTabs, InteractsWithForms, InteractsWithTable;

    public $soldeCompte;

    public $employee;

    public function mount(Employee $employee): void
    {
        $this->employee = $employee;

    }

    public function render()
    {
        return view('livewire.solde-table');
    }

    public function table(Table $table)
    {
        return $table
            ->query(SoldeCompte::query()->where('employee_id', $this->employee->id))
            ->recordUrl(null)
            ->columns([
                TextColumn::make('donnees')
                    ->weight(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? FontWeight::Bold : null)
                    ->size(fn ($record) => $record->donnees == SoldeCompte::TOTAL ? TextColumn\TextColumnSize::Large : null),
                TextInputColumn::make('montant')
                    ->type(fn ($record) => $record->donnees == SoldeCompte::TREIZIEME_MOIS || $record->donnees == SoldeCompte::PREAVIS ? 'select' : 'text')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS || $record->donnees == SoldeCompte::PREAVIS) {
                            $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                            $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;
                            $state = ((int) $state == $value) ? $salaire : $value;
                            SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->update(['montant' => $state]);
                        }
                    })
//                    ->hidden(fn ($record) => $record->donnees == SoldeCompte::SALAIRE_MENSUEL || $record->donnees == SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU)
                    ->label('Montant')
                    ->default(0)
                    ->disabled(fn ($record) => $record->donnees == SoldeCompte::SALAIRE_MENSUEL || $record->donnees == SoldeCompte::NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU || $record->donnees == SoldeCompte::TOTAL || $record->donnees == SoldeCompte::TREIZIEME_MOIS || $record->donnees == SoldeCompte::PREAVIS),

            ])
            ->filters([

            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename($this->employee->nom.' '.$this->employee->prenoms.' - Solde Compte'),
                    ]),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Exporter')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        try {
                            redirect(route('download-soldes', ['records' => $this->getTableRecords()->pluck('id')->implode(',')]));

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
                    }),
            ])
            ->actions([
                Action::make('add')
                    ->label(function ($record) {
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS) {
                            $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                            $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;

                            if ((int) $value == $salaire) {
                                return 'Retrancher';
                            } else {
                                return 'Ajouter';
                            }
                        }
                        if ($record->donnees == SoldeCompte::PREAVIS) {
                            return 'Ajouter';
                        }
                    })
                    ->visible(function ($record) {
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS || $record->donnees == SoldeCompte::PREAVIS) {
                            return true;
                        } else {
                            return false;
                        }
                    })
                    ->icon(function ($record) {
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS) {
                            $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                            $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;

                            if ((int) $value == $salaire) {
                                return 'heroicon-o-minus';
                            } else {
                                return 'heroicon-o-plus';
                            }
                        }
                        if ($record->donnees == SoldeCompte::PREAVIS) {
                            return 'heroicon-o-plus';
                        }
                    })
                    ->form(function ($record) {
                        if ($record->donnees == SoldeCompte::PREAVIS) {
                            $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                            $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;

                            return [
                                TextInput::make('nbre_mois')
                                    ->numeric()
                                    ->maxValue(12)
                                    ->required()
                                    ->rules(['required', 'numeric', 'max:12'])
                                    ->label('Nombre de mois')
                                    ->default(1),
                            ];
                        } else {
                            return null;
                        }
                    })
                    ->modalWidth('xl')
                    ->action(function (array $data, $record) {
                        $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                        $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS) {
                            if ((int) $value == $salaire) {
                                $solde = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first();
                                $solde->montant = 0;

                                return $solde->update();
                            } else {
                                $solde = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first();
                                $solde->montant = $salaire;

                                return $solde->update();
                            }
                        }
                        if ($record->donnees == SoldeCompte::PREAVIS) {
                            $solde = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first();
                            $solde->montant = $salaire * $data['nbre_mois'];

                            return $solde->update();
                        }

                    })
                    ->color(function ($record) {
                        if ($record->donnees == SoldeCompte::TREIZIEME_MOIS) {
                            $salaire = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', SoldeCompte::SALAIRE_MENSUEL)->first()->montant;
                            $value = SoldeCompte::where('employee_id', $record->employee_id)->where('donnees', $record->donnees)->first()->montant;

                            if ((int) $value == $salaire) {
                                return 'danger';
                            } else {
                                return 'primary';
                            }
                        }
                        if ($record->donnees == SoldeCompte::PREAVIS) {
                            return 'primary';
                        }
                    }),
            ])
            ->selectable(false)
            ->paginated(false);

    }
}

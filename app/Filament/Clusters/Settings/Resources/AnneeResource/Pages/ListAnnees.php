<?php

namespace App\Filament\Clusters\Settings\Resources\AnneeResource\Pages;

use App\Filament\Clusters\Settings\Resources\AnneeResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Resources\Pages\ListRecords;

class ListAnnees extends ListRecords
{
    protected static string $resource = AnneeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading("Session d'exercice")
                ->form([
                    Fieldset::make('Ouvrir une nouvelle année')
                        ->schema([
                            TextInput::make('nom')
                                ->label('Session')
                                ->readOnly()
                                ->columnSpan(2),
                            DatePicker::make('debut')
                                ->label('Date de début')
                                ->required()
                                ->columnSpan(1)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('nom', state: date('Y', strtotime($state))))
                                ->placeholder('Date de début de l\'année'),
                            DatePicker::make('fin')
                                ->label('Date de fin')
                                ->required()
                                ->columnSpan(1)
                                ->placeholder('Date de fin de l\'année'),
                        ]),

                ])->modalWidth('xl'),
        ];
    }
}

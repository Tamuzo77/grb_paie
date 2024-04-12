<?php

namespace App\Filament\Pages;

use App\Models\Company;
use Filament\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GRB extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists, InteractsWithForms;

    //    protected static ?string $navigationIcon = 'heroicon-s-information-circle';

    protected static string $view = 'filament.pages.g-r-b';

    protected static ?string $navigationGroup = 'Paramètres';

    protected static ?int $navigationSort = 2;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Modifer les informations de la société')
                ->label('Modifier les Informations')
                ->form([
                    Fieldset::make('Informations')
                        ->schema([
                            TextInput::make('nom')
                                ->default(Company::first()->nom)
                                ->required()
                                ->columnSpan(2)
                                ->label('Nom'),
                            TextInput::make('adresse')
                                ->default(Company::first()->adresse)
                                ->columnSpan(2)
                                ->label('Adresse'),
                            TextInput::make('telephone')
                                ->default(Company::first()->telephone)
                                ->columnSpan(1)
                                ->label('Téléphone'),
                            TextInput::make('email')
                                ->default(Company::first()->email)
                                ->columnSpan(2)
                                ->label('Email'),
                            TextInput::make('slogan')
                                ->default(Company::first()->slogan)
                                ->columnSpan(1)
                                ->label('Slogan'),
                            TextInput::make('directeur')
                                ->default(Company::first()->directeur)
                                ->columnSpan('full')
                                ->label('Directeur / Directrice'),
                            FileUpload::make('signature')
                                ->columnSpan(2)
                                ->label('Signature'),
                            FileUpload::make('logo')
                                ->columnSpan(2)
                                ->label('Logo')
                                ->directory('logos')
                                ->acceptedFileTypes(['image/*'])
                        ])
                        ->columns(4)

                ])
                ->record(Company::first())
                ->action(function (array $data) {
                    Company::first()->update($data);
                    Notification::make()
                        ->title('Informations mises à jour')
                        ->body('Les informations de la société ont été mises à jour avec succès.')
                        ->success()
                        ->send();
                })
                ->successNotificationTitle('Informations mises à jour')
                ->color('primary')
                ->icon('heroicon-s-pencil')
        ];
    }

    public function productInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(Company::first())
            ->schema([
                Section::make('Informations de la société')
                    ->schema([
                        TextEntry::make('nom')
                            ->size('lg')
                            ->weight(FontWeight::Bold)
                            ->label('Nom de la société'),
                        TextEntry::make('adresse')
                            ->size('lg')
                            ->label('Adresse'),
                        TextEntry::make('telephone')
                            ->badge()
                            ->weight(FontWeight::Medium)
                            ->color('primary')
                            ->size('lg')
                            ->copyable()
                            ->label('Téléphone'),
                        TextEntry::make('email')
//                        ->badge()
                            ->icon('heroicon-m-envelope')
                            ->iconColor('primary')
                            ->size('lg')
                            ->weight(FontWeight::Medium)
                            ->color('primary')
                            ->copyable()
                            ->label('Email'),
                        TextEntry::make('slogan')
                            ->label('Slogan'),
                        TextEntry::make('directeur')
                            ->size('lg')
                            ->weight(FontWeight::Black)
                            ->label('Directeur / Directrice'),
                        ImageEntry::make('logo')
                            ->size('lg')
                            ->label('Logo')
                            ->width('100')
                            ->height('100')
                            ->columnSpanFull()
                    ])
                    ->columns(3)
            ]);
    }

    public function systemInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(Company::first())
            ->state([
                ['tauxIts' => '3.6']
            ])
            ->schema([
                Section::make('Informations du système')
                    ->schema([
                        TextEntry::make('tauxIts')
                            ->size('lg')
                            ->weight(FontWeight::Bold)
                            ->label('Taux CNSS : 3.6%'),
                    ])
                    ->columns(3)
            ]);

    }
}

<x-filament-panels::page>
    @php
        $mois = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ]
    @endphp

    <x-filament::section.heading>

        Mois de: {{ $mois[now()->format('F')]  }}
    </x-filament::section.heading>

    @foreach($this->records ??[] as $record)
        <livewire:solde-table :employee="$record"/>

    @endforeach

</x-filament-panels::page>

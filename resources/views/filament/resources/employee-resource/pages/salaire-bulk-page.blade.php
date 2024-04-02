<x-filament-panels::page>

    <x-filament::section.heading>

        Mois de: {{ now()->format('F') }}
    </x-filament::section.heading>

    @foreach($this->records ??[] as $record)
        <livewire:solde-table :employee="$record"/>

    @endforeach

</x-filament-panels::page>

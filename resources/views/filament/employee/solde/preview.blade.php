@php
$data = $this->table->getActions()[1];

@endphp
<div>
    <x-filament-tables::table>
        <x-slot:header>
            <x-filament-tables::row class="gap-4">
                <td class="text-gray-500">DONNEES</td>
                <td class="text-gray-500">Montant</td>
            </x-filament-tables::row>
        </x-slot:header>


        <x-filament-tables::row>
            <x-filament-tables::cell>
                <span class="text-gray-900">rr</span>
            </x-filament-tables::cell>
            <x-filament-tables::cell>
                <span class="text-gray-900">ff</span>
            </x-filament-tables::cell>
        </x-filament-tables::row>


    </x-filament-tables::table>

</div>

<div>
    {{-- Be like water. --}}
    <x-filament::section.heading class="mb-4 ">
        <div class="my-2 text-xl" >Employé: {{$this->employee->employee->nom . ' ' . $this->employee->employee->prenoms}}</div>
        <x-filament::section.description> </x-filament::section.description>
    </x-filament::section.heading>
    {{ $this->table }}


</div>

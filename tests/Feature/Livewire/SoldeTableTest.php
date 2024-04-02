<?php

use App\Livewire\SoldeTable;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SoldeTable::class)
        ->assertStatus(200);
});

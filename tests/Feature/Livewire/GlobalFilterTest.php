<?php

use App\Livewire\GlobalFilter;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(GlobalFilter::class)
        ->assertStatus(200);
});

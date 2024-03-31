<?php

use App\Livewire\CotisationsClientOverview;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CotisationsClientOverview::class)
        ->assertStatus(200);
});

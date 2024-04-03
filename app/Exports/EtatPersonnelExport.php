<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EtatPersonnelExport implements FromView
{
    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $employees = $this->client->employees()->get();
        return view('exports.etats-personnel',
        [
            'employees' => $employees,
        ]);
    }
}

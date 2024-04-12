<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

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
    {   $company = Company::first();
        $employees = $this->client->employees()->get();
        return view('exports.etats-personnel',
        [
            'employees' => $employees,
            'company' => $company,
            'client' => $this->client
        ]);
    }
}

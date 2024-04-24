<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'nom' => 'GRB',
            'adresse' => 'Company Address',
            'telephone' => 'Company Phone',
            'email' => 'Company Email',
            'slogan' => 'Company Slogan',
            'directeur' => 'Company Director',
        ]);
    }
}

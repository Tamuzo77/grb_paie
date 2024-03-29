<?php

namespace Database\Seeders;

use App\Models\Annee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class AnneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Annee::create([
            'nom' => '2024',
            'debut' => now(),
            'fin' => now()->endOfYear() ,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Actions\GenereCode;
use App\Models\ModePaiement;
use Illuminate\Database\Seeder;

class ModePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modePaiements = [
            [
                'nom' => 'Caisse',
            ],
            ['nom' => 'Virement'],
            ['nom' => 'Chèque'],
        ];

        foreach ($modePaiements as $modePaiement) {
            \App\Models\ModePaiement::create($modePaiement + [
                'code' => (new GenereCode())->handle(ModePaiement::class, 'MP'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Actions\GenereCode;
use App\Models\TypePaiement;
use Illuminate\Database\Seeder;

class TypePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typePaiements = [
            ['nom' => 'Avance'],
            ['nom' => 'Prêt'],
            ['nom' => 'Salaire'],
        ];

        foreach ($typePaiements as $typePaiement) {
            \App\Models\TypePaiement::create($typePaiement + [
                'code' => (new GenereCode())->handle(TypePaiement::class, 'TP'),
            ]);
        }
    }
}

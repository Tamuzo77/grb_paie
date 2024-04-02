<?php

namespace Database\Seeders;

use App\Models\SoldeCompte;
use Illuminate\Database\Seeder;

class SoldeCompteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoldeCompte::create([
            'donnees' => 'Salaire mensuel',
        ]);
        SoldeCompte::create([
            'donnees' => 'Treizième mois',
        ]);
        SoldeCompte::create([
            'donnees' => 'Nombre de jours de congés payés dû',
        ]);
        SoldeCompte::create([
            'donnees' => 'Préavis',
        ]);
        SoldeCompte::create([
            'donnees' => 'Avance sur salaire',
        ]);
        SoldeCompte::create([
            'donnees' => 'Prêt entreprise',
        ]);

    }
}

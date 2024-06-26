<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['banks', 'clients', 'annees', 'employees', 'categories'];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'GRB Admin',
            'email' => 'jellaltamuzo@gmail.com',
            'password' => bcrypt('password'),
        ]);
        //
        $this->call(AnneeSeeder::class);
        $this->call(BankSeeder::class);
//        $this->call(ClientSeeder::class);
        $this->call(CategorySeeder::class);
        //        $this->call(EmployeeSeeder::class);

        $this->call(ModePaiementSeeder::class);
        $this->call(TypePaiementSeeder::class);
        $this->call(CompanySeeder::class);

        Role::create([
            'name' => Role::DIRECTRICE_GENERALE,
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => Role::DIRECTRICE_OPERATIONELLE,
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => Role::RESPONSABLE_COMMERCIAL,
            'guard_name' => 'web',
        ]);
    }
}

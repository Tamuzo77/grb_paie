<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['banks'];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //        \App\Models\User::factory()->create([
        //            'name' => 'GRB Admin',
        //            'email' => 'jellaltamuzo@gmail.com',
        //            'password' => bcrypt('password'),
        //        ]);

        $this->call(BankSeeder::class);
    }
}

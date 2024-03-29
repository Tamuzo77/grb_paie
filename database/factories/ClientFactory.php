<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => rand(100000, 999999),
            'nom' => fake()->company,
            'bank_id' => Bank::inRandomOrder()->first()->id,
            'adresse' => fake()->address,
            'email' => fake()->companyEmail,
            'telephone' => fake()->phoneNumber,
            'nom_donneur_ordre' => fake()->lastName,
            'prenom_donneur_ordre' => fake()->firstName,

        ];
    }
}

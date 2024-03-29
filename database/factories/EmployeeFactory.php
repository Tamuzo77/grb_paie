<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Client;
use App\Services\ItsService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salaire = rand(0, 90000000);
        return [
            'nom' => fake()->lastName,
            'prenoms' => fake()->firstName,
            'client_id' => Client::inRandomOrder()->first()->id,
            'annee_id' => 1,
            'bank_id' => Bank::inRandomOrder()->first()->id,
            'telephone' => fake()->phoneNumber,
            'salaire' => $salaire,
            'email' => fake()->email,
            'categorie' => fake()->jobTitle,
            'date_naissance' => fake()->date(),
            'lieu_naissance' => fake()->city,
            'nb_enfants' => rand(0,8),
            'sexe' => array_rand(['M','F','I']),
            'tauxIts' => ItsService::getIts(rand($salaire)),
            'situation_matrimoniale' => fake()->realText(3),
            'npi' => rand(1000000000000000, 9999999999999999),
            'numero_compte' => fake()->creditCardNumber,
        ];
    }
}

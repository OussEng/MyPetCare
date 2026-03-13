<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vet>
 */
class VetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numeroLicence' => fake()->numerify('LIC-####'),
            'nomClinique' => fake()->company(),
            'NbAnsExperience' => fake()->numberBetween(1, 30),
            'certification' => fake()->word(),
            'dateDeNaissance' => fake()->date(),
            'licenceExpiration' => fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
            'adresseClinique' => fake()->address(),
            'user_id' => User::factory(),
        ];
    }


}

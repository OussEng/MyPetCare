<?php

namespace Database\Factories;

use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->firstName(),
            'race' => fake()->word(),
            'dateNaissance' => fake()->date(),
            'poids' => fake()->randomFloat(2, 1, 10),
            'sexe_id' => Sexe::factory(),
            'espece_id' => Espece::factory(),
            'user_id' => User::factory(),
        ];
    }
}

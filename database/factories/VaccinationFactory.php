<?php

namespace Database\Factories;

use App\Models\Espece;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_vaccine' => fake()->word(),
            'info' => fake()->sentence(),
            'espece_id' => Espece::factory(),
        ];
    }
}

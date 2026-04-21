<?php

namespace Database\Factories;

use App\Models\Langue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Langue>
 */
class LangueFactory extends Factory
{
    protected $model = Langue::class;

    public function definition(): array
    {
        return [
            'libelle' => fake()->unique()->randomElement(['Français', 'Anglais', 'Arabe', 'Espagnol', 'Allemand', 'Italien']),
        ];
    }
}


<?php

namespace Database\Factories;

use App\Enums\Etat;
use App\Models\Animal;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RendezVous>
 */
class RendezVousFactory extends Factory
{
    protected $model = RendezVous::class;

    public function definition(): array
    {
        return [
            'dateHeureDebut' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
            'motif'          => fake()->sentence(),
            'etat'           => Etat::CONFIRMER,
            'user_id'        => User::factory(),
            'animal_id'      => Animal::factory(),
            'veterinaire_id' => Vet::factory(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn () => ['etat' => Etat::CONFIRMER]);
    }

    public function finished(): static
    {
        return $this->state(fn () => ['etat' => Etat::TERMINER]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['etat' => Etat::ANULLER]);
    }
}


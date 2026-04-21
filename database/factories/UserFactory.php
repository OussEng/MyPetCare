<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prenom' => fake()->firstName(),
            'nom' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'numero' => fake()->phoneNumber(),
            'adresse' => fake()->address(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function vet(): static
    {
        return $this->afterCreating(function (User $user) {
            Vet::factory()->create(['user_id' => $user->id]);

            $role = Role::firstOrCreate(['role' => 'veterinarian']);
            $user->roles()->attach($role->id);
        });
    }
}

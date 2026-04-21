<?php

namespace Tests\Feature\Auth;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->post('/register', [
            'nom'                  => 'Dupont',
            'prenom'               => 'Jean',
            'email'                => 'jean.dupont@example.com',
            'password'             => 'Password1!',
            'password_confirmation' => 'Password1!',
            'numero'               => '0612345678',
            'adresse'              => '12 rue de la Paix, Paris',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }
}

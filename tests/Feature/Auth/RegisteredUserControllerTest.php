<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_create_shows_registration_form_for_guest(): void
    {
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    public function test_create_redirects_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('register'))->assertRedirect();
    }


    private function validRegistrationData(array $override = []): array
    {
        return array_merge([
            'prenom'               => 'Jean',
            'nom'                  => 'Dupont',
            'email'                => 'jean@test.com',
            'password'             => 'Password1!',
            'password_confirmation' => 'Password1!',
            'numero'               => '0612345678',
            'adresse'              => '1 rue de la Paix',
        ], $override);
    }

    public function test_store_creates_user_in_database(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register'), $this->validRegistrationData())
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => 'jean@test.com']);
    }

    public function test_store_attaches_user_role(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register'), $this->validRegistrationData());

        $user = User::where('email', 'jean@test.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('user'));
    }

    public function test_store_authenticates_user_after_registration(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register'), $this->validRegistrationData());

        $this->assertAuthenticated();
    }

    public function test_store_redirects_to_home_after_registration(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register'), $this->validRegistrationData())
            ->assertRedirect(route('home'));
    }

    public function test_store_with_missing_email_fails_validation(): void
    {
        $this->post(route('register'), $this->validRegistrationData(['email' => '']))
            ->assertSessionHasErrors('email');
    }

    public function test_store_with_duplicate_email_fails_validation(): void
    {
        User::factory()->create(['email' => 'jean@test.com']);

        $this->post(route('register'), $this->validRegistrationData(['email' => 'jean@test.com']))
            ->assertSessionHasErrors('email');
    }

    public function test_store_with_missing_prenom_fails_validation(): void
    {
        $this->post(route('register'), $this->validRegistrationData(['prenom' => '']))
            ->assertSessionHasErrors('prenom');
    }

    public function test_store_with_missing_nom_fails_validation(): void
    {
        $this->post(route('register'), $this->validRegistrationData(['nom' => '']))
            ->assertSessionHasErrors('nom');
    }

    public function test_store_with_weak_password_fails_validation(): void
    {
        $this->post(route('register'), $this->validRegistrationData([
            'password'             => 'weak',
            'password_confirmation' => 'weak',
        ]))->assertSessionHasErrors('password');
    }

    public function test_store_with_password_mismatch_fails_validation(): void
    {
        $this->post(route('register'), $this->validRegistrationData([
            'password'             => 'Password1!',
            'password_confirmation' => 'DifferentPass1!',
        ]))->assertSessionHasErrors('password');
    }

    public function test_store_does_not_create_user_on_validation_failure(): void
    {
        $this->post(route('register'), $this->validRegistrationData(['email' => '']));

        $this->assertDatabaseMissing('users', ['prenom' => 'Jean', 'nom' => 'Dupont']);
    }

    public function test_store_redirects_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('register'), $this->validRegistrationData())
            ->assertRedirect();
    }
}


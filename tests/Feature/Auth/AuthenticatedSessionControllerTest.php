<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_shows_login_form_for_guest(): void
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function test_create_redirects_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect();
    }


    public function test_store_with_valid_credentials_authenticates_and_redirects_to_home(): void
    {
        $user = User::factory()->create(['email' => 'client@test.com']);

        $this->post(route('login'), [
            'email'    => 'client@test.com',
            'password' => 'password',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_store_vet_user_redirects_to_veterinaire_backoffice(): void
    {
        $vet = User::factory()->vet()->create(['email' => 'vet@test.com']);

        $this->post(route('login'), [
            'email'    => 'vet@test.com',
            'password' => 'password',
        ])->assertRedirect(route('veterinaire.backoffice'));
    }

    public function test_store_with_invalid_password_fails(): void
    {
        User::factory()->create(['email' => 'user@test.com']);

        $this->post(route('login'), [
            'email'    => 'user@test.com',
            'password' => 'wrong_password',
        ])->assertSessionHasErrors('email');
    }

    public function test_store_with_unknown_email_fails(): void
    {
        $this->post(route('login'), [
            'email'    => 'nobody@test.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_store_with_missing_email_fails_validation(): void
    {
        $this->post(route('login'), ['password' => 'password'])
            ->assertSessionHasErrors('email');
    }

    public function test_store_with_missing_password_fails_validation(): void
    {
        $this->post(route('login'), ['email' => 'user@test.com'])
            ->assertSessionHasErrors('password');
    }

    public function test_store_does_not_authenticate_with_wrong_credentials(): void
    {
        User::factory()->create(['email' => 'user@test.com']);

        $this->post(route('login'), [
            'email'    => 'user@test.com',
            'password' => 'wrong',
        ]);

        $this->assertGuest();
    }



    public function test_destroy_logs_out_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_destroy_redirects_to_home(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');
    }

    public function test_destroy_invalidates_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();
    }
}


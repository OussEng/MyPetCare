<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_edit_redirects_guest_to_login(): void
    {
        $this->get(route('profile.edit'))->assertRedirect('/login');
    }

    public function test_edit_returns_200_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('profile.edit'))->assertStatus(200);
    }

    public function test_edit_passes_user_to_view(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('profile.edit'))->assertViewHas('user', $user);
    }



    public function test_update_redirects_guest_to_login(): void
    {
        $this->patch(route('profile.update'))->assertRedirect('/login');
    }

    public function test_update_with_valid_data_redirects_to_profile_edit(): void
    {
        $user = User::factory()->create(['email' => 'old@test.com']);

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                'prenom'  => 'Jean',
                'nom'     => 'Dupont',
                'email'   => 'new@test.com',
                'numero'  => '0612345678',
                'adresse' => '12 rue de Paris',
            ])
            ->assertRedirect(route('profile.edit'));
    }

    public function test_update_with_missing_prenom_fails_validation(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                // 'prenom' intentionally omitted
                'nom'     => 'Dupont',
                'email'   => 'valid@test.com',
                'numero'  => '0612345678',
                'adresse' => '12 rue de Paris',
            ])
            ->assertSessionHasErrors('prenom');
    }
    public function test_update_with_missing_email_fails_validation(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('profile.update'), ['name' => 'Jean Dupont'])
            ->assertSessionHasErrors('email');
    }

    public function test_update_with_duplicate_email_fails_validation(): void
    {
        User::factory()->create(['email' => 'taken@test.com']);
        $user = User::factory()->create(['email' => 'mine@test.com']);

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name'  => 'Jean',
                'email' => 'taken@test.com',
            ])
            ->assertSessionHasErrors('email');
    }



    public function test_destroy_redirects_guest_to_login(): void
    {
        $this->delete(route('profile.destroy'))->assertRedirect('/login');
    }

    public function test_destroy_with_wrong_password_fails_validation(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete(route('profile.destroy'), ['password' => 'wrong_password'])
            ->assertSessionHasErrors('password', null, 'userDeletion');
    }

    public function test_destroy_with_correct_password_deletes_account_and_redirects(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete(route('profile.destroy'), ['password' => 'password'])
            ->assertRedirect('/');

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_destroy_logs_out_user_after_deletion(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete(route('profile.destroy'), ['password' => 'password']);

        $this->assertGuest();
    }
}


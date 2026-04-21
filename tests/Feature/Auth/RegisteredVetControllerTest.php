<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredVetControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_create_shows_vet_registration_form_for_guest(): void
    {
        $this->get(route('register_vet.form'))
            ->assertStatus(200)
            ->assertViewIs('auth.register-vet');
    }

    public function test_create_redirects_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('register_vet.form'))->assertRedirect();
    }


    private function validUserData(array $override = []): array
    {
        return array_merge([
            'prenom'               => 'Sophie',
            'nom'                  => 'Vétérinaire',
            'email'                => 'sophie@vet.com',
            'password'             => 'Password1!',
            'password_confirmation' => 'Password1!',
            'numero'               => '0612345678',
            'adresse'              => '5 allée des Vétérinaires',
        ], $override);
    }

    private function validVetData(array $override = []): array
    {
        return array_merge([
            'numeroLicence'    => 'LIC-4242',
            'nomClinique'      => 'Clinique Animaux',
            'adresseClinique'  => '12 rue des Animaux',
            'NbAnsExperience'  => 5,
            'dateDeNaissance'  => '1985-03-20',
            'licenceExpiration' => '2030-12-31',
            'certification'    => 'DVM',
        ], $override);
    }

    public function test_store_creates_user_and_vet_profile(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register_vet.save'), array_merge($this->validUserData(), $this->validVetData()));

        $this->assertDatabaseHas('users', ['email' => 'sophie@vet.com']);
        $this->assertDatabaseHas('veterinaires', ['numeroLicence' => 'LIC-4242']);
    }

    public function test_store_vet_attaches_user_role(): void
    {
        Role::create(['role' => 'user']);

        $this->post(route('register_vet.save'), array_merge($this->validUserData(), $this->validVetData()));

        $user = User::where('email', 'sophie@vet.com')->first();
        $this->assertTrue($user->hasRole('user'));
    }

    public function test_store_authenticates_user_after_registration(): void
    {

        Role::create(['role' => 'user']);

        $this->post(route('register_vet.save'), array_merge($this->validUserData(), $this->validVetData()));

        $this->assertAuthenticated();
    }

    public function test_store_with_missing_user_email_fails_validation(): void
    {
        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(['email' => '']), $this->validVetData())
        )->assertSessionHasErrors('email');
    }

    public function test_store_with_missing_numeroLicence_fails_validation(): void
    {
        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(), $this->validVetData(['numeroLicence' => '']))
        )->assertSessionHasErrors('numeroLicence');
    }

    public function test_store_with_missing_nomClinique_fails_validation(): void
    {
        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(), $this->validVetData(['nomClinique' => '']))
        )->assertSessionHasErrors('nomClinique');
    }

    public function test_store_with_missing_dateDeNaissance_fails_validation(): void
    {
        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(), $this->validVetData(['dateDeNaissance' => '']))
        )->assertSessionHasErrors('dateDeNaissance');
    }

    public function test_store_with_duplicate_email_fails_validation(): void
    {
        User::factory()->create(['email' => 'sophie@vet.com']);

        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(), $this->validVetData())
        )->assertSessionHasErrors('email');
    }

    public function test_store_does_not_create_vet_on_user_validation_failure(): void
    {
        $this->post(
            route('register_vet.save'),
            array_merge($this->validUserData(['email' => '']), $this->validVetData())
        );

        $this->assertDatabaseMissing('veterinaires', ['numeroLicence' => 'LIC-4242']);
    }
}


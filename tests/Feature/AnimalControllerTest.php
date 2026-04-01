<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vaccination;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnimalControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_index_not_logged_in()
    {
        $response = $this->get('/mes-animaux');
        $response->assertRedirect('/login');

    }

    public function test_index_logged_in(){

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mes-animaux');
        $response->assertStatus(200);
    }

    public function test_show_animals(){
        $user = User::factory()->create();
        $animal = Animal::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user)->get('/mes-animaux')->assertStatus(200)->assertViewHas('animals');

    }

    public function test_client_delete_animal()
    {

        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($client)
            ->delete(route('animaux.delete', ['animal' => $animal->id]))
            ->assertRedirect(route('animaux'));

        $this->assertDatabaseMissing('animals', ['id' => $animal->id]);
    }

    public function test_client_delete_unowned_animal()
    {
        $client = User::factory()->create();
        $otherClient = User::factory()->create();

        $animal = Animal::factory()->create(['user_id' => $otherClient->id]);

        $this->actingAs($client)->delete(route('animaux.delete', ['animal' => $animal->id]))
            ->assertStatus(403);

    }

    public function test_vet_delete_client_animal()
    {
        $vet = User::factory()->vet()->create();
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($vet)
            ->delete(route('animaux.delete', ['animal' => $animal->id]))
            ->assertRedirect(route('veterinaire.client', ['client' => $client->id]));

    }

    public function test_animal_create_form_not_logged_in()
    {
        $response = $this->get('/mes-animaux')->assertRedirect('/login');

    }

    public function test_animal_create_form_logged_in()
    {
        $user = User::factory()->create();
        Espece::factory()->create();
        Sexe::factory()->create();

        $this->actingAs($user)->get('/creer-animal')->assertStatus(200)
            ->assertViewIs('animal.creer-animal')
            ->assertViewHas('especes')
            ->assertViewHas('sexes');

    }

    public function test_save_animal()
    {
        $user = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe = Sexe::factory()->create();

        $this->actingAs($user)
            ->post(route('animaux.save'), [
                'nom' => 'Rex',
                'espece_id' => $espece->id,
                'sexe_id' => $sexe->id,
                'race' => 'Labrador',
                'dateNaissance' => '2020-01-01',
                'poids' => "10.5",
                'user_id' => $user->id,
            ])
            ->assertRedirect(route('animaux'));

        $this->assertDatabaseHas('animals', ["nom" => "Rex"]);
    }

    public function test_vet_save_client_animal()
    {
        $vet = User::factory()->vet()->create();
        $client = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe = Sexe::factory()->create();
        $this->actingAs($vet)
            ->post(route('animaux.save'), [
                'nom' => 'Rex',
                'espece_id' => $espece->id,
                'sexe_id' => $sexe->id,
                'race' => 'Labrador',
                'dateNaissance' => '2020-01-01',
                'poids' => "10.5",
                'user_id' => $client->id,
            ])
            ->assertRedirect(route('veterinaire.client', ['client' => $client->id]));
        $this->assertDatabaseHas('animals', ["nom" => "Rex"]);
    }


    public function test_missing_animal_required_feild()
    {
        $user = User::factory()->create();
        $espece = Espece::factory()->create();


        $this->actingAs($user)
            ->post(route('animaux.save'), [
              //'nom' => 'Rex',
                'espece_id' => $espece->id,
              //'sexe_id' => $sexe->id,
                'race' => 'Labrador',
                'dateNaissance' => '2020-01-01',
                'poids' => "10.5",
                'user_id' => $user->id,
            ])
            ->assertSessionHasErrors(['nom', 'sexe_id']);

    }

    public function test_client_animal_vaccination()
    {
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($client)
            ->get(route('vaccinations',['id' => $animal->id]))
            ->assertStatus(200)
            ->assertViewIs('animal.list-vaccinations')
            ->assertViewHas('vaccinations');

    }

    public function test_vet_client_animal_vaccination()
    {
        $vet = User::factory()->vet()->create();
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($vet)
            ->get(route('vaccinations',['id' => $animal->id]))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.Clients.client-animal-vaccination')
            ->assertViewHas('vaccinations');

    }

    public function test_client_unowned_animal_vaccination()
    {
        $client = User::factory()->create();
        $otherClient = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $otherClient->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($client)
            ->get(route('vaccinations',['id' => $animal->id]))
            ->assertStatus(403);

    }

    public function test_add_vaccination()
    {
        $vet = User::factory()->vet()->create();
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($vet)
            ->post(route('vaccinations.add', ['id' => $animal->id]), ['vaccination_id' => $vaccination->id])
            ->assertRedirect(route('vaccinations', $animal->id));

    }

    public function test_unadd_vaccination()
    {
        $vet = User::factory()->vet()->create();
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($vet)
            ->post(route('vaccination.remove', [
                'animal_id' => $animal->id,
                'vaccination_id' => $vaccination->id
            ]))
            ->assertRedirect(route('vaccinations', $animal->id));
    }

    public function test_client_cant_add_vaccination()
    {

        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($client)
            ->post(route('vaccinations.add', ['id' => $animal->id]), ['vaccination_id' => $vaccination->id])
            ->assertStatus(403);
    }

    public function test_client_cant_unadd_vaccination()
    {
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);
        $vaccination = Vaccination::factory()->create(['espece_id' => $animal->espece->id]);

        $this->actingAs($client)
            ->post(route('vaccination.remove', [
                'animal_id' => $animal->id,
                'vaccination_id' => $vaccination->id
            ]))            ->assertStatus(403);
    }

    // ── edit ────────────────────────────────────────────────────────────────

    public function test_animal_edit_form_not_logged_in(): void
    {
        $user   = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $this->get(route('animaux.edit', $animal->id))
            ->assertRedirect('/login');
    }

    public function test_animal_edit_form_owner_sees_prefilled_form(): void
    {
        $user   = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('animaux.edit', $animal->id))
            ->assertStatus(200)
            ->assertViewIs('animal.modifier-animal')
            ->assertViewHas('animal')
            ->assertViewHas('especes')
            ->assertViewHas('sexes');
    }

    public function test_animal_edit_form_stranger_is_forbidden(): void
    {
        $owner  = User::factory()->create();
        $other  = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('animaux.edit', $animal->id))
            ->assertStatus(403);
    }

    public function test_vet_can_access_edit_form_of_any_animal(): void
    {
        $vet    = User::factory()->vet()->create();
        $client = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($vet)
            ->get(route('animaux.edit', $animal->id))
            ->assertStatus(200)
            ->assertViewIs('animal.modifier-animal');
    }

    // ── update ──────────────────────────────────────────────────────────────

    public function test_owner_can_update_animal(): void
    {
        $user   = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe   = Sexe::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('animaux.update', $animal->id), [
                'nom'           => 'Nouveau Nom',
                'espece_id'     => $espece->id,
                'sexe_id'       => $sexe->id,
                'race'          => 'Labrador',
                'dateNaissance' => '2019-03-15',
                'poids'         => '12',
            ])
            ->assertRedirect(route('animaux'));

        $this->assertDatabaseHas('animals', ['id' => $animal->id, 'nom' => 'Nouveau Nom']);
    }

    public function test_vet_can_update_client_animal(): void
    {
        $vet    = User::factory()->vet()->create();
        $client = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe   = Sexe::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($vet)
            ->put(route('animaux.update', $animal->id), [
                'nom'       => 'VetNom',
                'espece_id' => $espece->id,
                'sexe_id'   => $sexe->id,
            ])
            ->assertRedirect(route('veterinaire.client', ['client' => $client->id]));

        $this->assertDatabaseHas('animals', ['id' => $animal->id, 'nom' => 'VetNom']);
    }

    public function test_stranger_cannot_update_others_animal(): void
    {
        $owner  = User::factory()->create();
        $other  = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe   = Sexe::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->put(route('animaux.update', $animal->id), [
                'nom'       => 'Hack',
                'espece_id' => $espece->id,
                'sexe_id'   => $sexe->id,
            ])
            ->assertStatus(403);
    }

    public function test_update_animal_validation_fails_when_required_fields_missing(): void
    {
        $user   = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('animaux.update', $animal->id), [
                //
                'race' => 'Labrador',
            ])
            ->assertSessionHasErrors(['nom', 'espece_id', 'sexe_id']);
    }

    public function test_update_animal_not_logged_in_redirects_to_login(): void
    {
        $user   = User::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $this->put(route('animaux.update', $animal->id), ['nom' => 'Test'])
            ->assertRedirect('/login');
    }

}

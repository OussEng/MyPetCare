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


}

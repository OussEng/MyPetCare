<?php

namespace Tests\Feature;

use App\Enums\Etat;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\RendezVous;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RendezVousControllerTest extends TestCase
{
    use RefreshDatabase;



    public function test_index_redirects_guest_to_login(): void
    {
        $vet = Vet::factory()->create();

        $this->get(route('rendez-vous.index', $vet->id))->assertRedirect('/login');
    }

    public function test_index_returns_200_for_authenticated_user(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();

        $this->actingAs($client)
            ->get(route('rendez-vous.index', $vet->id))
            ->assertStatus(200)
            ->assertViewIs('rendez-vous.rendez-vous')
            ->assertViewHas('data');
    }

    public function test_index_returns_404_for_unknown_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('rendez-vous.index', 99999))
            ->assertStatus(404);
    }

    public function test_index_passes_selected_date_from_query_param(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();

        $response = $this->actingAs($client)
            ->get(route('rendez-vous.index', ['id' => $vet->id, 'date' => '2026-05-10']))
            ->assertStatus(200);

        $data = $response->viewData('data');
        $this->assertSame('2026-05-10', $data['selectedDate']);
    }

    public function test_index_with_date_returns_8_available_slots(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();

        $response = $this->actingAs($client)
            ->get(route('rendez-vous.index', ['id' => $vet->id, 'date' => '2026-06-15']))
            ->assertStatus(200);

        $data = $response->viewData('data');
        $this->assertCount(8, $data['slots']);
    }



    public function test_save_redirects_guest_to_login(): void
    {
        $vet = Vet::factory()->create();

        $this->post(route('rendez-vous.store', $vet->id))->assertRedirect('/login');
    }

    public function test_save_with_valid_data_creates_rendez_vous_and_redirects(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($client)
            ->post(route('rendez-vous.store', $vet->id), [
                'dateHeureDebut' => '2026-05-10 10:00:00',
                'motif'          => 'Visite',
                'animal_id'      => $animal->id,
            ])
            ->assertRedirect('/mes-rendez-vous');

        $this->assertDatabaseHas('rendez_vous', [
            'motif'          => 'Visite',
            'user_id'        => $client->id,
            'veterinaire_id' => $vet->id,
        ]);
    }

    public function test_save_with_missing_motif_fails_validation(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($client)
            ->post(route('rendez-vous.store', $vet->id), [
                'dateHeureDebut' => '2026-05-10 10:00:00',
                'animal_id'      => $animal->id,
            ])
            ->assertSessionHasErrors('motif');
    }

    public function test_save_with_missing_dateHeureDebut_fails_validation(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($client)
            ->post(route('rendez-vous.store', $vet->id), [
                'motif'     => 'Consultation',
                'animal_id' => $animal->id,
            ])
            ->assertSessionHasErrors('dateHeureDebut');
    }

    public function test_save_with_missing_animal_id_fails_validation(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();

        $this->actingAs($client)
            ->post(route('rendez-vous.store', $vet->id), [
                'dateHeureDebut' => '2026-05-10 10:00:00',
                'motif'          => 'Consultation',
            ])
            ->assertSessionHasErrors('animal_id');
    }

    public function test_save_assigns_CONFIRMER_status_automatically(): void
    {
        $client = User::factory()->create();
        $vet    = Vet::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $client->id]);

        $this->actingAs($client)
            ->post(route('rendez-vous.store', $vet->id), [
                'dateHeureDebut' => '2026-05-10 10:00:00',
                'motif'          => 'Visite',
                'animal_id'      => $animal->id,
            ]);

        $this->assertDatabaseHas('rendez_vous', ['etat' => Etat::CONFIRMER->value]);
    }



    public function test_list_redirects_guest_to_login(): void
    {
        $this->get(route('rendez-vous.list'))->assertRedirect('/login');
    }

    public function test_list_returns_200_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('rendez-vous.list'))
            ->assertStatus(200)
            ->assertViewIs('animal.mes-rendez-vous')
            ->assertViewHas('rendezvous');
    }

    public function test_list_shows_only_user_rendez_vous(): void
    {
        $user  = User::factory()->create();
        RendezVous::factory()->count(2)->create(['user_id' => $user->id]);
        RendezVous::factory()->count(3)->create(); // other users

        $response = $this->actingAs($user)
            ->get(route('rendez-vous.list'))
            ->assertStatus(200);

        $rendezvous = $response->viewData('rendezvous');
        $this->assertSame(2, $rendezvous->total());
    }

    public function test_list_returns_empty_when_no_rendez_vous(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('rendez-vous.list'));

        $rendezvous = $response->viewData('rendezvous');
        $this->assertSame(0, $rendezvous->total());
    }
}


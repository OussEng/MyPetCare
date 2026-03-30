<?php

namespace Tests\Feature;

use App\Enums\Etat;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Langue;
use App\Models\RendezVous;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vet;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VeterinaireControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_list_vets_redirects_guest_to_login(): void
    {
        $this->get(route('list.vets'))->assertRedirect('/login');
    }

    public function test_list_vets_returns_200_with_vets_view(): void
    {
        $user = User::factory()->create();
        Vet::factory()->count(2)->create();

        $this->actingAs($user)
            ->get(route('list.vets'))
            ->assertStatus(200)
            ->assertViewIs('vet.vet-list')
            ->assertViewHas('vets');
    }

    public function test_list_vets_shows_empty_list_when_no_vets(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('list.vets'))
            ->assertStatus(200)
            ->assertViewHas('vets');
    }


    public function test_vet_profile_redirects_guest_to_login(): void
    {
        $this->get(route('vet.profile', 1))->assertRedirect('/login');
    }

    public function test_vet_profile_returns_200_for_existing_vet(): void
    {
        $user = User::factory()->create();
        $vet  = Vet::factory()->create();

        $this->actingAs($user)
            ->get(route('vet.profile', $vet->id))
            ->assertStatus(200)
            ->assertViewIs('vet.vet-profile')
            ->assertViewHas('vet');
    }

    public function test_vet_profile_returns_404_for_unknown_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('vet.profile', 99999))
            ->assertStatus(404);
    }


    public function test_backoffice_redirects_guest_to_login(): void
    {
        $this->get(route('veterinaire.backoffice'))->assertRedirect('/login');
    }

    public function test_backoffice_returns_403_for_non_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('veterinaire.backoffice'))->assertStatus(403);
    }

    public function test_backoffice_returns_200_for_vet_user(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('veterinaire.backoffice'))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.veretinarian-backoffice');
    }

    public function test_backoffice_view_has_rendez_vous_and_pending(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('veterinaire.backoffice'))
            ->assertViewHas('rendez_vous')
            ->assertViewHas('pending');
    }


    public function test_list_clients_returns_403_for_non_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('veterinaire.clients'))->assertStatus(403);
    }

    public function test_list_clients_returns_200_for_vet(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('veterinaire.clients'))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.Clients.clients-list')
            ->assertViewHas('clients');
    }

    public function test_list_clients_filters_by_search_param(): void
    {
        $vet = User::factory()->vet()->create();
        User::factory()->create(['nom' => 'Dupont']);

        $this->actingAs($vet)
            ->get(route('veterinaire.clients', ['search' => 'Dupont']))
            ->assertStatus(200)
            ->assertViewHas('clients');
    }


    public function test_client_profile_returns_403_for_non_vet(): void
    {
        $user   = User::factory()->create();
        $client = User::factory()->create();

        $this->actingAs($user)->get(route('veterinaire.client', $client->id))->assertStatus(403);
    }

    public function test_client_profile_returns_200_for_vet(): void
    {
        $vet    = User::factory()->vet()->create();
        $client = User::factory()->create();
        Espece::factory()->create();
        Sexe::factory()->create();

        $this->actingAs($vet)
            ->get(route('veterinaire.client', $client->id))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.Clients.client-profile')
            ->assertViewHas('client')
            ->assertViewHas('especes')
            ->assertViewHas('sexes');
    }

    public function test_client_profile_returns_404_for_unknown_client(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)->get(route('veterinaire.client', 99999))->assertStatus(404);
    }


    public function test_vet_rendez_vous_list_returns_403_for_non_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('vet.rendez-vous.list'))->assertStatus(403);
    }

    public function test_vet_rendez_vous_list_returns_200_for_vet(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('vet.rendez-vous.list'))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.veterinaire-rendez_vous-list')
            ->assertViewHas('rendezVous');
    }

    public function test_vet_rendez_vous_list_filters_by_etat(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('vet.rendez-vous.list', ['etat' => Etat::EN_ATTENT->value]))
            ->assertStatus(200);
    }

    public function test_vet_rendez_vous_list_filters_by_jour(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('vet.rendez-vous.list', ['jour' => 'today']))
            ->assertStatus(200);
    }


    public function test_profile_returns_403_for_non_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('veterinaire.profile'))->assertStatus(403);
    }

    public function test_profile_returns_200_for_vet(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('veterinaire.profile'))
            ->assertStatus(200)
            ->assertViewIs('vet.Back Office.veterinaire-profile')
            ->assertViewHas('vet')
            ->assertViewHas('langues');
    }


    public function test_editLangues_returns_403_for_non_vet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('veterinaire.add-langues'))->assertStatus(403);
    }

    public function test_editLangues_syncs_langues_and_redirects_back(): void
    {
        $vet    = User::factory()->vet()->create();
        $langue = Langue::factory()->create();

        $this->actingAs($vet)
            ->post(route('veterinaire.add-langues'), ['langues' => [$langue->id]])
            ->assertRedirect();
    }

    public function test_editLangues_with_empty_langues_clears_all(): void
    {
        $vet    = User::factory()->vet()->create();
        $langue = Langue::factory()->create();
        $vet->vet->langues()->sync([$langue->id]);

        $this->actingAs($vet)
            ->post(route('veterinaire.add-langues'), ['langues' => []])
            ->assertRedirect();

        $this->assertCount(0, $vet->vet->fresh()->langues);
    }
}


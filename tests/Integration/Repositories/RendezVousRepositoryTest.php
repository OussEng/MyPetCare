<?php

namespace Tests\Integration\Repositories;

use App\Enums\Etat;
use App\Models\Animal;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use App\Repositories\RendezVousRepository;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RendezVousRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private RendezVousRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RendezVousRepository();
    }

    private function makeVetWithUser(): array
    {
        $user = User::factory()->create();
        $vet  = Vet::factory()->create(['user_id' => $user->id]);
        return [$user, $vet];
    }



    public function test_findAllByVet_returns_only_vet_appointments(): void
    {
        [$user1, $vet1] = $this->makeVetWithUser();
        [$user2, $vet2] = $this->makeVetWithUser();

        RendezVous::factory()->count(2)->create(['veterinaire_id' => $vet1->id]);
        RendezVous::factory()->count(3)->create(['veterinaire_id' => $vet2->id]);

        $result = $this->repository->findAllByVet($vet1->id)->get();

        $this->assertCount(2, $result);
        $result->each(fn($rv) => $this->assertSame($vet1->id, $rv->veterinaire_id));
    }

    public function test_findAllByVet_returns_empty_when_no_appointments(): void
    {
        [$user, $vet] = $this->makeVetWithUser();

        $result = $this->repository->findAllByVet($vet->id)->get();

        $this->assertCount(0, $result);
    }

    public function test_findAllByVet_orders_today_first(): void
    {
        [$user, $vet] = $this->makeVetWithUser();
        $animal       = Animal::factory()->create();

        $past   = RendezVous::factory()->create([
            'veterinaire_id' => $vet->id, 'animal_id' => $animal->id,
            'dateHeureDebut' => Carbon::yesterday()->setTime(10, 0)->toDateTimeString(),
        ]);
        $today  = RendezVous::factory()->create([
            'veterinaire_id' => $vet->id, 'animal_id' => $animal->id,
            'dateHeureDebut' => CarbonImmutable::today()->setTime(11, 0)->toDateTimeString(),
        ]);
        $future = RendezVous::factory()->create([
            'veterinaire_id' => $vet->id, 'animal_id' => $animal->id,
            'dateHeureDebut' => Carbon::tomorrow()->setTime(9, 0)->toDateTimeString(),
        ]);

        $result = $this->repository->findAllByVet($vet->id)->get();

        $this->assertSame($today->id, $result->first()->id);
    }



    public function test_findAllByUser_returns_paginated_appointments_for_user(): void
    {
        $user = User::factory()->create();
        RendezVous::factory()->count(3)->create(['user_id' => $user->id]);
        RendezVous::factory()->count(2)->create(); // other users

        $result = $this->repository->findAllByUser($user->id);

        $this->assertSame(3, $result->total());
    }

    public function test_findAllByUser_returns_paginator_of_10(): void
    {
        $user = User::factory()->create();

        $result = $this->repository->findAllByUser($user->id);

        $this->assertSame(10, $result->perPage());
    }

    public function test_findAllByUser_returns_empty_when_no_appointments(): void
    {
        $user = User::factory()->create();

        $result = $this->repository->findAllByUser($user->id);

        $this->assertSame(0, $result->total());
    }



    public function test_create_persists_rendez_vous_in_database(): void
    {
        $user   = User::factory()->create();
        $vet    = Vet::factory()->create();
        $animal = Animal::factory()->create(['user_id' => $user->id]);

        $data = [
            'dateHeureDebut' => '2026-05-10 10:00:00',
            'motif'          => 'Contrôle annuel',
            'user_id'        => $user->id,
            'veterinaire_id' => $vet->id,
            'animal_id'      => $animal->id,
            'etat'           => Etat::CONFIRMER->value,
        ];

        $result = $this->repository->create($data);

        $this->assertInstanceOf(RendezVous::class, $result);
        $this->assertDatabaseHas('rendez_vouses', ['motif' => 'Contrôle annuel']);
    }



    public function test_findTodayApointement_returns_todays_confirmed_appointments(): void
    {

        RendezVous::factory()->create([
            'etat'           => Etat::CONFIRMER,
            'dateHeureDebut' => CarbonImmutable::today()->setTime(10, 0)->toDateTimeString(),
        ]);
        RendezVous::factory()->create([
            'etat'           => Etat::TERMINER,
            'dateHeureDebut' => CarbonImmutable::today()->setTime(11, 0)->toDateTimeString(),
        ]);

        $result = $this->repository->findTodayApointement();

        $this->assertCount(1, $result);
    }

    public function test_findTodayApointement_excludes_other_days(): void
    {
        RendezVous::factory()->create([
            'etat'           => Etat::TERMINER,
            'dateHeureDebut' => Carbon::yesterday()->setTime(9, 0)->toDateTimeString(),
        ]);

        $result = $this->repository->findTodayApointement();

        $this->assertCount(0, $result);
    }
}


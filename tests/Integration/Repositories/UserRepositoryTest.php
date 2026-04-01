<?php

namespace Tests\Integration\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
    }



    public function test_create_persists_user_and_returns_model(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = bcrypt('secret');

        $result = $this->repository->create($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertDatabaseHas('users', ['email' => $result->email]);
    }

    public function test_create_assigns_correct_email(): void
    {
        $data = User::factory()->make(['email' => 'unique@test.com'])->toArray();
        $data['password'] = bcrypt('secret');

        $result = $this->repository->create($data);

        $this->assertSame('unique@test.com', $result->email);
    }


    public function test_attachRole_attaches_existing_role_to_user(): void
    {
        Role::create(['role' => 'user']);
        $user = User::factory()->create();

        $this->repository->attachRole($user, 'user');

        $this->assertTrue($user->hasRole('user'));
    }

    public function test_attachRole_throws_when_role_does_not_exist(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $user = User::factory()->create();
        $this->repository->attachRole($user, 'nonexistent_role');
    }


    public function test_findAllClients_excludes_veterinarians(): void
    {
        $vet    = User::factory()->vet()->create();
        $client = User::factory()->create();
        Role::firstOrCreate(['role' => 'user']);
        $this->repository->attachRole($client, 'user');

        $result = $this->repository->findAllClients();

        $ids = $result->pluck('id')->toArray();
        $this->assertContains($client->id, $ids);
        $this->assertNotContains($vet->id, $ids);
    }

    public function test_findAllClients_returns_paginator_of_10(): void
    {
        User::factory()->count(15)->create();

        $result = $this->repository->findAllClients();

        $this->assertSame(10, $result->perPage());
    }

    public function test_findAllClients_with_search_filters_by_nom(): void
    {
        User::factory()->create(['nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'j@d.com']);
        User::factory()->create(['nom' => 'Martin', 'prenom' => 'Paul', 'email' => 'p@m.com']);

        $result = $this->repository->findAllClients('Dupont');

        $this->assertSame(1, $result->total());
        $this->assertSame('Dupont', $result->first()->nom);
    }

    public function test_findAllClients_with_search_filters_by_prenom(): void
    {
        User::factory()->create(['nom' => 'Dupont', 'prenom' => 'Alicia', 'email' => 'a@d.com']);
        User::factory()->create(['nom' => 'Martin', 'prenom' => 'Paul', 'email' => 'p@m.com']);

        $result = $this->repository->findAllClients('Alicia');

        $this->assertSame(1, $result->total());
    }

    public function test_findAllClients_with_search_filters_by_email(): void
    {
        User::factory()->create(['nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'unique@search.com']);
        User::factory()->create(['nom' => 'Martin', 'prenom' => 'Paul', 'email' => 'other@mail.com']);

        $result = $this->repository->findAllClients('unique@search.com');

        $this->assertSame(1, $result->total());
    }

    public function test_findAllClients_returns_all_when_no_search(): void
    {
        User::factory()->count(3)->create();

        $result = $this->repository->findAllClients();

        $this->assertGreaterThanOrEqual(3, $result->total());
    }


    public function test_findClient_returns_correct_user(): void
    {
        $user = User::factory()->create(['nom' => 'Bertrand']);

        $result = $this->repository->findClient($user->id);

        $this->assertSame($user->id, $result->id);
        $this->assertSame('Bertrand', $result->nom);
    }

    public function test_findClient_throws_ModelNotFoundException_for_unknown_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->findClient(99999);
    }

    public function test_switch_user_role(): void
    {
        $user = User::factory()->create();
        Role::firstOrCreate(['role' => 'user']);
        Role::firstOrCreate(['role' => 'vet']);
        $this->repository->attachRole($user, 'user');
        $this->repository->switchRole($user, 'vet');
        $this->assertSame(true, $user->hasRole('vet'));

    }


}


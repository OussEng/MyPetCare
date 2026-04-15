<?php

namespace Tests\Unit\Services;

use App\DTOs\Requests\RegisterUserDTO;
use App\DTOs\Response\UserResponseDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserRepository $repoMock;
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(UserRepository::class);
        $this->service  = new UserService($this->repoMock);
    }

    private function makeUserWithRelations(array $override = []): User
    {
        $user = User::factory()->make(array_merge([
            'id' => 1, 'prenom' => 'Jean', 'nom' => 'Dupont',
            'email' => 'jean@test.com', 'numero' => '0600', 'adresse' => '1 r',
        ], $override));
        $user->setRelation('animals', collect());
        $user->setRelation('rendervous', collect());

        return $user;
    }


    public function test_register_creates_user_with_hashed_password_and_attaches_role(): void
    {
        $dto = new RegisterUserDTO('Jean', 'Dupont', 'jean@test.com', 'password', 612345678, '1 r');

        $user = $this->makeUserWithRelations();

        DB::shouldReceive('transaction')->once()->andReturnUsing(fn($cb) => $cb());
        $this->repoMock->shouldReceive('create')
            ->once()
            ->withArgs(fn($data) => $data['email'] === 'jean@test.com' && $data['prenom'] === 'Jean')
            ->andReturn($user);
        $this->repoMock->shouldReceive('attachRole')->once()->with($user, 'user');

        $result = $this->service->register($dto, 'user');

        $this->assertInstanceOf(User::class, $result);
    }

    public function test_register_hashes_password_before_storing(): void
    {
        $dto = new RegisterUserDTO('Jean', 'Dupont', 'jean@test.com', 'plaintext', 612345678, '1 r');

        $user = $this->makeUserWithRelations();

        DB::shouldReceive('transaction')->once()->andReturnUsing(fn($cb) => $cb());
        $this->repoMock->shouldReceive('create')
            ->once()
            ->withArgs(fn($data) => $data['password'] !== 'plaintext')
            ->andReturn($user);
        $this->repoMock->shouldReceive('attachRole')->once();

        $this->service->register($dto, 'user');

        $this->assertTrue(true);
    }

    public function test_register_attaches_correct_role(): void
    {
        $dto  = new RegisterUserDTO('Jean', 'D', 'j@t.com', 'pass', 612345678, '1 r');
        $user = $this->makeUserWithRelations();

        DB::shouldReceive('transaction')->once()->andReturnUsing(fn($cb) => $cb());
        $this->repoMock->shouldReceive('create')->once()->andReturn($user);
        $this->repoMock->shouldReceive('attachRole')->once()->with($user, 'user');

        $this->service->register($dto);

        $this->assertTrue(true);
    }


    public function test_getAllClients_returns_paginator_transformed_with_UserResponseDTOs(): void
    {
        $user  = $this->makeUserWithRelations();
        $items = collect([$user]);

        $paginator = new LengthAwarePaginator($items, 1, 10);
        $this->repoMock->shouldReceive('findAllClients')->with(null)->once()->andReturn($paginator);

        $result = $this->service->getAllClients();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertInstanceOf(UserResponseDTO::class, $result->first());
    }

    public function test_getAllClients_passes_search_string_to_repository(): void
    {
        $paginator = new LengthAwarePaginator(collect(), 0, 10);
        $this->repoMock->shouldReceive('findAllClients')->with('dupont')->once()->andReturn($paginator);

        $this->service->getAllClients('dupont');

        $this->assertTrue(true);
    }

    public function test_getAllClients_with_null_search_calls_findAllClients_with_null(): void
    {
        $paginator = new LengthAwarePaginator(collect(), 0, 10);
        $this->repoMock->shouldReceive('findAllClients')->with(null)->once()->andReturn($paginator);

        $this->service->getAllClients(null);

        $this->assertTrue(true);
    }


    public function test_getClient_returns_UserResponseDTO(): void
    {
        $user = $this->makeUserWithRelations(['id' => 3]);
        $this->repoMock->shouldReceive('findClient')->with(3)->once()->andReturn($user);

        $result = $this->service->getClient(3);

        $this->assertInstanceOf(UserResponseDTO::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}





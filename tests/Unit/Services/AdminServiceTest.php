<?php

namespace Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use App\Repositories\AnimalRepository;
use App\Repositories\UserRepository;
use App\Repositories\VeterinaireRepository;
use App\Services\AdminService;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class AdminServiceTest extends TestCase
{
    private AdminService $service;
    private VeterinaireRepository $vetRepoMock;
    private UserRepository $userRepoMock;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vetRepoMock = Mockery::mock(VeterinaireRepository::class);
        $this->userRepoMock = Mockery::mock(UserRepository::class);
        $this->service = new AdminService($this->vetRepoMock, $this->userRepoMock);
    }

    public function test_accept_pending_vet(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);
        $vet  = Vet::factory()->make(['id' => 99, 'user_id' => 1]);
        $vet->setRelation('user', $user);

        $user->role = 'user';

        $this->vetRepoMock
            ->shouldReceive('findVet')
            ->with(99)
            ->once()
            ->andReturn($vet);

        $this->userRepoMock
            ->shouldReceive('switchRole')
            ->with($user, 'veterinarian')
            ->once();

        $this->vetRepoMock
            ->shouldReceive('review')
            ->with($vet)
            ->once();

        $this->service->acceptVet($vet->id);
    }

    public function test_reject_pending_vet(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);
        $vet  = Vet::factory()->make(['id' => 99, 'user_id' => 1]);
        $vet->setRelation('user', $user);

        $user->role = 'user';

        $this->vetRepoMock
            ->shouldReceive('findVet')
            ->with(99)
            ->once()
            ->andReturn($vet);

        $this->userRepoMock
            ->shouldNotReceive('switchRole');

        $this->vetRepoMock
            ->shouldReceive('review')
            ->with($vet)
            ->once();

        $this->service->rejectVet($vet->id);
    }

    public function test_delete_user(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);

        $this->userRepoMock
            ->shouldReceive('findClient')
            ->with(1)
            ->once()
            ->andReturn($user);

        $this->userRepoMock
            ->shouldReceive('delete')
            ->with($user)
            ->once();


        $this->service->deleteUser(1);
    }

    public function test_delete_vet(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);
        $vet = Vet::factory()->make(['id' => 99, 'user_id' => 1]);

        $this->vetRepoMock
            ->shouldReceive('findVet')
            ->with(99)
            ->once()
            ->andReturn($vet);

        $this->vetRepoMock
            ->shouldReceive('delete')
            ->with($vet)
            ->once();

        $this->service->deleteVet(99);
    }

    public function test_restore_user(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);


        $this->userRepoMock
            ->shouldReceive('findTrashedClient')
            ->with(1)
            ->once()
            ->andReturn($user);

        $this->userRepoMock
            ->shouldReceive('restore')
            ->with($user)
            ->once();

        $this->service->restoreUser(1);
    }

    public function test_restore_vet(): void
    {
        $this->expectNotToPerformAssertions();

        $user = User::factory()->make(['id' => 1]);
        $vet = Vet::factory()->make(['id' => 99, 'user_id' => 1]);


        $this->vetRepoMock
            ->shouldReceive('findTrashedVet')
            ->with(99)
            ->once()
            ->andReturn($vet);

        $this->vetRepoMock
            ->shouldReceive('restore')
            ->with($vet)
            ->once();

        $this->service->restoreVet(99);
    }





}

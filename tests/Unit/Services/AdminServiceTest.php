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


}

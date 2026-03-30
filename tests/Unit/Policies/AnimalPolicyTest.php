<?php

namespace Tests\Unit\Policies;

use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Policies\AnimalPolicy;
use Mockery;
use Tests\TestCase;

class AnimalPolicyTest extends TestCase
{
    private AnimalPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new AnimalPolicy();
    }

    private function makeAnimalOwnedBy(int $ownerId): Animal
    {
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());
        $sexe  = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);
        $owner = Mockery::mock(User::class)->makePartial();
        $owner->id = $ownerId;

        $animal = Animal::factory()->make([
            'id'        => 1,
            'user_id'   => $ownerId,
            'sexe_id'   => 1,   // override FK
            'espece_id' => 1,   // override FK
        ]);
        $animal->setRelation('espece', $espece);
        $animal->setRelation('sexe', $sexe);
        $animal->setRelation('user', $owner);
        $animal->setRelation('vaccinations', collect());

        return $animal;
    }


    public function test_view_owner_can_view_own_animal(): void
    {
        $user   = Mockery::mock(User::class)->makePartial();
        $user->id = 5;
        $user->shouldReceive('hasRole')->andReturn(false);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertTrue($this->policy->view($user, $animal));
    }

    public function test_view_veterinarian_can_view_any_animal(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 99;
        $user->shouldReceive('hasRole')->with('veterinarian')->andReturn(true);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertTrue($this->policy->view($user, $animal));
    }

    public function test_view_stranger_cannot_view_others_animal(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 99;
        $user->shouldReceive('hasRole')->with('veterinarian')->andReturn(false);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertFalse($this->policy->view($user, $animal));
    }


    public function test_delete_owner_can_delete_own_animal(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 5;
        $user->shouldReceive('hasRole')->andReturn(false);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertTrue($this->policy->delete($user, $animal));
    }

    public function test_delete_veterinarian_can_delete_any_animal(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 99;
        $user->shouldReceive('hasRole')->with('veterinarian')->andReturn(true);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertTrue($this->policy->delete($user, $animal));
    }

    public function test_delete_stranger_cannot_delete_others_animal(): void
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 99;
        $user->shouldReceive('hasRole')->with('veterinarian')->andReturn(false);

        $animal = $this->makeAnimalOwnedBy(5);

        $this->assertFalse($this->policy->delete($user, $animal));
    }


    public function test_viewAny_always_returns_false(): void
    {
        $user = User::factory()->make();

        $this->assertFalse($this->policy->viewAny($user));
    }

    public function test_create_always_returns_false(): void
    {
        $user = User::factory()->make();

        $this->assertFalse($this->policy->create($user));
    }

    public function test_update_always_returns_false(): void
    {
        $user   = User::factory()->make();
        $animal = $this->makeAnimalOwnedBy(1);

        $this->assertFalse($this->policy->update($user, $animal));
    }

    public function test_restore_always_returns_false(): void
    {
        $user   = User::factory()->make();
        $animal = $this->makeAnimalOwnedBy(1);

        $this->assertFalse($this->policy->restore($user, $animal));
    }

    public function test_forceDelete_always_returns_false(): void
    {
        $user   = User::factory()->make();
        $animal = $this->makeAnimalOwnedBy(1);

        $this->assertFalse($this->policy->forceDelete($user, $animal));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}



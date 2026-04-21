<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['role' => 'admin']);
        $user->roles()->attach($role->id);

        return $user;
    }

    public function makePendingVet(): Vet
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['role' => 'user']);
        $user->roles()->attach($role->id);

        return Vet::factory()->create(['isReviewed' => false, 'user_id' => $user->id]);

    }

    public function test_backoffice_redirects_guest_to_login(): void
    {
        $this->get(route('admin.backoffice'))->assertRedirect('/login');
    }

    public function test_backoffice_returns_403_for_non_admin_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.backoffice'))
            ->assertStatus(403);
    }

    public function test_backoffice_returns_403_for_veterinarian(): void
    {
        $vet = User::factory()->vet()->create();

        $this->actingAs($vet)
            ->get(route('admin.backoffice'))
            ->assertStatus(403);
    }

    public function test_backoffice_returns_200_for_admin_user(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->get(route('admin.backoffice'))
            ->assertStatus(200);
    }

    public function test_backoffice_renders_correct_view(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->get(route('admin.backoffice'))
            ->assertViewIs('admin.backoffice');
    }

    public function test_admin_can_get_pending_vets()
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)
            ->get(route('admin.pending-vets'))
            ->assertStatus(200);
    }

    public function test_pending_vets_returns_pending_vets()
    {
        $admin = $this->makeAdmin();
        $pendingVet = $this->makePendingVet();

        $this->actingAs($admin)
            ->get(route('admin.pending-vets'))
            ->assertStatus(200)
            ->assertViewHas('vets', function ($vets) use ($pendingVet) {
                return $vets->contains(fn ($vet) => $vet->id === $pendingVet->id);
            });
    }

}


<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdminUser(): User
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['role' => 'admin']);
        $user->roles()->attach($role->id);

        return $user;
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
        $admin = $this->makeAdminUser();

        $this->actingAs($admin)
            ->get(route('admin.backoffice'))
            ->assertStatus(200);
    }

    public function test_backoffice_renders_correct_view(): void
    {
        $admin = $this->makeAdminUser();

        $this->actingAs($admin)
            ->get(route('admin.backoffice'))
            ->assertViewIs('admin.backoffice');
    }
}


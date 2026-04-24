<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Database\Seeders\RoleSeeder;
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

    public function makeVet(): Vet
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['role' => 'veterinarian']);
        $user->roles()->attach($role->id);

        return Vet::factory()->create(['isReviewed' => true, 'user_id' => $user->id]);

    }

    public function makeUser(): User
    {
        $role = Role::firstOrCreate(['role' => 'user']);
        $user = User::factory()->create();
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

    public function test_admin_can_get_vet_detail()
    {
        $admin = $this->makeAdmin();
        $vet = $this->makeVet();


        $this->actingAs($admin)
            ->get(route('admin.vet.detail', $vet->id))
            ->assertStatus(200);
    }

    public function test_vet_detail_returns_vet_detail()
    {
        $admin = $this->makeAdmin();
        $vet = $this->makeVet();

        $this->actingAs($admin)
            ->get(route('admin.vet.detail', $vet->id))
            ->assertStatus(200)
            ->assertViewHas('vet', function ($vetDetails) use ($vet) {
                return $vetDetails->id === $vet->id;
            })->assertViewIs('admin.vet.detail-vet');
    }

    public function test_admin_accept_vet()
    {
        $this->seed(RoleSeeder::class);

        $admin = $this->makeAdmin();
        $vet = $this->makePendingVet();

        $this->assertDatabaseHas('veterinaires', [
            'id' => $vet->id,
        ]);


        $this->actingAs($admin)
            ->post(route('admin.vet.accept', ["id" => $vet->id]))
            ->assertRedirect(route('admin.pending-vets'));

        $this->assertDatabaseHas('veterinaires', [
            'id' => $vet->id,
            'isReviewed' => true,
        ]);

        $this->assertDatabaseHas('role_user', [
            'user_id' => $vet->user->id,
            'role_id' => Role::where('role', 'veterinarian')->first()->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.vet.accept', ['id' => 9999]))
            ->assertNotFound();

    }


    public function test_admin_reject_vet()
    {
        $this->seed(RoleSeeder::class);

        $admin = $this->makeAdmin();
        $vet = $this->makePendingVet();

        $this->assertDatabaseHas('veterinaires', [
            'id' => $vet->id,
        ]);


        $this->actingAs($admin)
            ->post(route('admin.vet.reject', ["id" => $vet->id]))
            ->assertRedirect(route('admin.pending-vets'));

        $this->assertDatabaseHas('veterinaires', [
            'id' => $vet->id,
            'isReviewed' => true,
        ]);

        $this->assertDatabaseHas('role_user', [
            'user_id' => $vet->user->id,
            'role_id' => Role::where('role', 'user')->first()->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.vet.reject', ['id' => 9999]))
            ->assertNotFound();

    }

    public function test_admin_can_get_clients_and_vets()
    {
        $admin = $this->makeAdmin();
        $vet = $this->makeVet();
        $user = $this->makeUser();

        $this->actingAs($admin)
            ->get(route('admin.users'))
            ->assertStatus(200)
            ->assertViewHas('vets', function ($vets) use ($vet) {
                return $vets->contains(fn ($v) => $v->id === $vet->id);
            })
            ->assertViewHas('clients', function ($clients) use ($user) {
                return $clients->contains(fn ($c) => $c->id === $user->id);
            });
    }

    public function test_admin_delete_user()
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser();

        $this->actingAs($admin)
            ->delete(route('admin.user.disable', ['id' => $user->id]))
            ->assertRedirect(route('admin.users'));

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

    }

    public function test_admin_delete_vet(){

        $admin = $this->makeAdmin();
        $vet = $this->makeVet();

        $this->actingAs($admin)
            ->delete(route('admin.vet.disable', ['id' => $vet->id]))
            ->assertRedirect(route('admin.users'));

        $this->assertSoftDeleted('veterinaires', [
            'id' => $vet->id
        ]);


        $this->assertSoftDeleted('users', [
            "id" => $vet->user_id,
        ]);

    }

    public function test_admin_restore_user()
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser();

        $user->delete();

        $this->actingAs($admin)
            ->patch(route('admin.user.enable', ['id' => $user->id]))
            ->assertRedirect(route('admin.users'));

        $this->assertNotSoftDeleted('users', [
            'id' => $user->id,
        ]);

    }

    public function test_admin_restore_vet(){
        $admin = $this->makeAdmin();
        $vet = $this->makeVet();

        $vet->delete();
        $vet->user->delete();


        $this->actingAs($admin)
            ->patch(route('admin.vet.enable', ['id' => $vet->id]))
            ->assertRedirect(route('admin.users'));

        $this->assertNotSoftDeleted('veterinaires', [
            'id' => $vet->id
        ]);

        $this->assertNotSoftDeleted('users', [
            'id' => $vet->user_id
        ]);

    }

}


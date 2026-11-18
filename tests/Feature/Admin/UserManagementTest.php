<?php

namespace Tests\Feature\Admin;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class UserManagementTest extends TestCase
{
    use RefreshDatabase;


    private function admin(array $attributes = []): User
    {
        return User::factory()->create(array_merge(['rol' => 'admin', 'activo' => true], $attributes));
    }



    public function test_admin_dashboard_contains_the_modal_user_management(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get('/dashboard?tab=usuarios')
            ->assertOk()
            ->assertSee('Gestión de usuarios')
            ->assertSee('Crear usuario')
            ->assertSee('Gestión completa');
    }

    public function test_admin_can_create_user_with_individual_password(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post(route('admin.usuarios.store'), [
            'nombres' => 'Ana María', 'apellidos' => 'Pérez López', 'rol' => 'capturista',
            'password' => 'ClaveSegura123', 'password_confirmation' => 'ClaveSegura123',
        ])->assertRedirect(route('dashboard', ['tab' => 'usuarios']));
        $created = User::where('email', 'ana.perez@aduanasim.com')->first();
        $this->assertNotNull($created);
        $this->assertTrue(Hash::check('ClaveSegura123', $created->password));
        $this->assertTrue($created->activo);
    }


    public function test_admin_can_edit_their_own_profile_without_losing_admin_role(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->put(route('admin.usuarios.update', $admin), [
            'name' => 'Admin Actualizado', 'email' => 'admin.updated@example.com', 'rol' => 'capturista',
        ])->assertRedirect(route('dashboard', ['tab' => 'usuarios']));
        $admin->refresh();
        $this->assertSame('Admin Actualizado', $admin->name);
        $this->assertSame('admin', $admin->rol);
    }


    public function test_last_active_admin_cannot_be_suspended_or_deleted(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->patch(route('admin.usuarios.suspend', $admin))->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->activo);
        $this->actingAs($admin)->delete(route('admin.usuarios.destroy', $admin))->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }


    public function test_admin_can_delete_their_own_account_if_another_active_admin_remains(): void
    {
        $admin = $this->admin();
        $this->admin();
        $this->actingAs($admin)->delete(route('admin.usuarios.destroy', $admin))->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }


    public function test_suspended_account_cannot_authenticate(): void
    {
        $user = User::factory()->create(['activo' => false]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}

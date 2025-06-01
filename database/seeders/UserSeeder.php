<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createAgentUser();
        $this->createRegularUser();
    }

    /**
     * Crea un usuario administrador.
     */
    protected function createAdminUser(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles('admin');
    }

    /**
     * Crea un usuario agente.
     */
    protected function createAgentUser(): void
    {
        $agent = User::firstOrCreate(
            ['email' => 'agent@example.com'],
            [
                'name' => 'Agente',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $agent->syncRoles('agent');
    }

    /**
     * Crea un usuario normal.
     */
    protected function createRegularUser(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Usuario',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles('user');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions();
        $this->createRoles();
    }

    /**
     * Crea los permisos del sistema.
     */
    protected function createPermissions(): void
    {
        // Tickets
        Permission::firstOrCreate(['name' => 'create tickets']);
        Permission::firstOrCreate(['name' => 'view own tickets']);
        Permission::firstOrCreate(['name' => 'view all tickets']);
        Permission::firstOrCreate(['name' => 'update own tickets']);
        Permission::firstOrCreate(['name' => 'update all tickets']);
        Permission::firstOrCreate(['name' => 'delete own tickets']);
        Permission::firstOrCreate(['name' => 'delete all tickets']);
        Permission::firstOrCreate(['name' => 'assign tickets']);
        Permission::firstOrCreate(['name' => 'change ticket status']);
        
        // Categorías
        Permission::firstOrCreate(['name' => 'manage categories']);
        
        // Usuarios
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage agents']);
        
        // Configuración
        Permission::firstOrCreate(['name' => 'manage settings']);
    }

    /**
     * Crea los roles y asigna los permisos correspondientes.
     */
    protected function createRoles(): void
    {
        // Rol de Usuario
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions([
            'create tickets',
            'view own tickets',
            'update own tickets',
            'delete own tickets',
        ]);

        // Rol de Agente
        $agentRole = Role::firstOrCreate(['name' => 'agent']);
        $agentRole->syncPermissions([
            'view own tickets',
            'view all tickets',
            'update own tickets',
            'update all tickets',
            'change ticket status',
        ]);

        // Rol de Administrador
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());
    }
}

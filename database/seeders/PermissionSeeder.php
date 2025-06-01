<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Mapeo de roles y sus permisos correspondientes.
     *
     * @var array<string, array<int, string>>
     */
    protected array $rolePermissions = [
        'user' => [
            'tickets.create',
            'tickets.view.own',
            'tickets.update.own',
            'tickets.delete.own',
        ],
        'agent' => [
            'tickets.view.own',
            'tickets.view.all',
            'tickets.update.own',
            'tickets.update.all',
            'tickets.change-status',
        ],
        'admin' => ['*'], // Todos los permisos
    ];

    /**
     * Lista de todos los permisos agrupados por módulo.
     *
     * @var array<string, array<int, string>>
     */
    protected array $modulePermissions = [
        'tickets' => [
            'create' => 'Crear nuevos tickets',
            'view.own' => 'Ver tickets propios',
            'view.all' => 'Ver todos los tickets',
            'update.own' => 'Actualizar tickets propios',
            'update.all' => 'Actualizar cualquier ticket',
            'delete.own' => 'Eliminar tickets propios',
            'delete.all' => 'Eliminar cualquier ticket',
            'assign' => 'Asignar tickets',
            'change-status' => 'Cambiar estado de tickets',
        ],
        'categories' => [
            'manage' => 'Gestionar categorías',
        ],
        'users' => [
            'manage' => 'Gestionar usuarios',
        ],
        'agents' => [
            'manage' => 'Gestionar agentes',
        ],
        'settings' => [
            'manage' => 'Gestionar configuración del sistema',
        ],
    ];

    /**
     * Ejecuta los seeders de la base de datos.
     *
     * @return void
     */
    public function run(): void
    {
        // Resetear caché de roles y permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        DB::transaction(function () {
            $this->createPermissions();
            $this->createRoles();
        });
    }

    /**
     * Crea todos los permisos del sistema organizados por módulos.
     *
     * @return void
     */
    protected function createPermissions(): void
    {
        $this->command->info('Creando permisos...');
        $bar = $this->command->getOutput()->createProgressBar(
            count($this->modulePermissions, COUNT_RECURSIVE) - count($this->modulePermissions)
        );

        foreach ($this->modulePermissions as $module => $permissions) {
            $this->command->info("\nMódulo: " . ucfirst($module));
            
            foreach ($permissions as $action => $description) {
                $name = "{$module}.{$action}";
                
                Permission::firstOrCreate(
                    ['name' => $name],
                    ['description' => $description, 'guard_name' => 'web']
                );
                
                $bar->advance();
            }
        }
        
        $bar->finish();
        $this->command->newLine(2);
    }

    /**
     * Crea los roles y asigna los permisos correspondientes.
     *
     * @return void
     */
    protected function createRoles(): void
    {
        $this->command->info('Creando roles y asignando permisos...');
        
        foreach ($this->rolePermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );

            if ($permissions === ['*']) {
                $permissions = Permission::pluck('name')->toArray();
            }

            $role->syncPermissions($permissions);
            $this->command->info(" - Rol '{$roleName}' creado/actualizado con " . count($permissions) . " permisos");
        }
    }
}

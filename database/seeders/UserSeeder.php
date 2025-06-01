<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Ejecuta los seeders de la base de datos.
     * 
     * @throws \RuntimeException Si algún rol requerido no existe
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createAgentUser();
        $this->createRegularUser();
    }

    /**
     * Crea el usuario administrador con todos los permisos.
     * 
     * @return void
     * @throws \RuntimeException Si el rol 'admin' no existe
     */
    protected function createAdminUser(): void
    {
        $this->createUser(
            'admin@example.com',
            'Administrador',
            'password',
            'admin',
            'El rol de administrador no existe. Ejecute primero el PermissionSeeder.'
        );
    }

    /**
     * Crea un usuario con rol de agente.
     * 
     * @return void
     * @throws \RuntimeException Si el rol 'agent' no existe
     */
    protected function createAgentUser(): void
    {
        $this->createUser(
            'agent@example.com',
            'Agente',
            'password',
            'agent',
            'El rol de agente no existe. Ejecute primero el PermissionSeeder.'
        );
    }

    /**
     * Crea un usuario con rol de usuario normal.
     * 
     * @return void
     * @throws \RuntimeException Si el rol 'user' no existe
     */
    protected function createRegularUser(): void
    {
        $this->createUser(
            'user@example.com',
            'Usuario',
            'password',
            'user',
            'El rol de usuario no existe. Ejecute primero el PermissionSeeder.'
        );
    }

    /**
     * Crea un usuario y le asigna un rol específico.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     * @param string $roleName
     * @param string $roleErrorMessage
     * @return void
     * @throws \RuntimeException Si el rol no existe
     */
    protected function createUser(
        string $email, 
        string $name, 
        string $password,
        string $roleName,
        string $roleErrorMessage
    ): void {
        // Verificar si el rol existe
        if (!Role::where('name', $roleName)->exists()) {
            throw new \RuntimeException($roleErrorMessage);
        }

        // Buscar o crear el usuario
        $user = User::firstOrNew(['email' => $email]);
        
        // Actualizar o crear los datos del usuario
        $user->fill([
            'name' => $name,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $user->save();
        
        // Sincronizar roles (eliminar roles existentes y asignar el nuevo)
        $user->syncRoles($roleName);
        
        $this->command->info("Usuario {$user->email} creado/actualizado con el rol: {$roleName}");
    }
}

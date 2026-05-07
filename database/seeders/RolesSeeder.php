<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'inspector']);
        Role::firstOrCreate(['name' => 'suscriptor']);

        // Crear usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@buildiner.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');
    }
}
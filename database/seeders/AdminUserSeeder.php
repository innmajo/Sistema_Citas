<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Sembrar usuarios iniciales con roles y estados (Mínimo 2 usuarios requeridos)
     */
    public function run(): void
    {
        // Crear Administrador principal
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'General',
                'telefono' => '123456789',
                'password' => Hash::make('admin123'),
                'admin' => 1,
                'role' => 'admin',
                'confirmado' => 1,
                'token' => ''
            ]
        );

        // Crear Usuario estándar
        User::firstOrCreate(
            ['email' => 'cliente@gmail.com'],
            [
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'telefono' => '987654321',
                'password' => Hash::make('cliente123'),
                'admin' => 0,
                'role' => 'usuario',
                'confirmado' => 1,
                'token' => ''
            ]
        );
    }
}
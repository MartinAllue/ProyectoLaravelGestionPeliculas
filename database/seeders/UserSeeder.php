<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Crear 3 usuarios normales
        User::create([
            'name' => 'Martin Allue',
            'email' => 'alluemartin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Miguel Ramirez',
            'email' => 'ramirezmiguel@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'David Amadeo',
            'email' => 'amadeodavid@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}

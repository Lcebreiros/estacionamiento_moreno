<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe el usuario admin
        $existingUser = User::where('email', 'admin@estacionamiento.com')->first();

        if ($existingUser) {
            $this->command->info('El usuario administrador ya existe.');
            return;
        }

        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@estacionamiento.com',
            'password' => Hash::make('Admin2024!'),  // CAMBIAR EN PRODUCCIÓN
            'email_verified_at' => now(),
        ]);

        $this->command->info('Usuario administrador creado exitosamente!');
        $this->command->warn('Email: admin@estacionamiento.com');
        $this->command->warn('Contraseña: Admin2025!');
        $this->command->error('⚠️  IMPORTANTE: Cambia la contraseña después de iniciar sesión!');
    }
}

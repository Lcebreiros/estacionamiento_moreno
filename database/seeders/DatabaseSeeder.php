<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Horario;
use App\Models\Tarifa;
use App\Support\LandingDefaults;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(
            ['email' => 'leancebreiros@hotmail.com'],
            [
                'name' => 'Leandro',
                'password' => 'leandro1',
                'email_verified_at' => now(),
            ],
        );

        if (Horario::count() === 0) {
            foreach (LandingDefaults::horarios() as $item) {
                Horario::create($item);
            }
        }

        if (Tarifa::count() === 0) {
            foreach (LandingDefaults::tarifas() as $item) {
                Tarifa::create($item);
            }
        }
    }
}

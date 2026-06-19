<?php

namespace Database\Seeders;

use App\Models\User;
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
            'nombre' => 'Sergio',
            'apellido' => 'Kilos',
            'NIF' => 'A12345678',
            'email' => 'sergio@ksergio.com',
        ]);
    }
}

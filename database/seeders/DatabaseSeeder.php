<?php

namespace Database\Seeders;

use App\Models\Profesor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(NivelSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(ProfesorSeeder::class);

        $this->call(AlumnoSeeder::class);
        $this->call(UsuarioSeeder::class);

    }
}

<?php

namespace Database\Seeders;

use Database\Seeders\EventoSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NivelSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(ProfesorSeeder::class);
        $this->call(RecursoSeeder::class);
        $this->call(EventoSeeder::class);
        $this->call(AlumnoSeeder::class);


    }
}

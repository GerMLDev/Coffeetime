<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AlumnoSeeder extends Seeder
{
    public function run()
    {

    /*Ejemplo para iniciar sesion como alumno:
    {
    Usuario: carlosga1
     Contraseña: password1
    }
     y así sucesivamente.
    */
        $alumnos = [
            ['nombre' => 'Carlos', 'apellidos' => 'Garcia Fernandez'],
            ['nombre' => 'Manuel', 'apellidos' => 'Lopez Martinez'],
            ['nombre' => 'Javier', 'apellidos' => 'Perez Sanchez'],
            ['nombre' => 'Antonio', 'apellidos' => 'Rodriguez Gomez'],
            ['nombre' => 'Alejandro', 'apellidos' => 'Sanchez Martin'],
            ['nombre' => 'David', 'apellidos' => 'Fernandez Gonzalez'],
            ['nombre' => 'Jose', 'apellidos' => 'Martinez Perez'],
            ['nombre' => 'Pablo', 'apellidos' => 'Gonzalez Lopez'],
            ['nombre' => 'Miguel', 'apellidos' => 'Sanchez Garcia'],
            ['nombre' => 'Raul', 'apellidos' => 'Fernandez Rodriguez'],
            ['nombre' => 'Laura', 'apellidos' => 'Martin Gomez'],
            ['nombre' => 'Ana', 'apellidos' => 'Perez Fernandez'],
            ['nombre' => 'Marta', 'apellidos' => 'Gomez Lopez'],
            ['nombre' => 'Patricia', 'apellidos' => 'Lopez Sanchez'],
            ['nombre' => 'Elena', 'apellidos' => 'Martinez Gonzalez'],
            ['nombre' => 'Isabel', 'apellidos' => 'Sanchez Rodriguez'],
            ['nombre' => 'Cristina', 'apellidos' => 'Fernandez Garcia'],
            ['nombre' => 'Beatriz', 'apellidos' => 'Rodriguez Perez'],
            ['nombre' => 'Sofia', 'apellidos' => 'Gomez Martin'],
            ['nombre' => 'Carmen', 'apellidos' => 'Martinez Sanchez']
        ];

        foreach ($alumnos as $i => $alumno) {
            //Email
            $email = $alumno['email'] ?? strtolower($alumno['nombre'] . '.' . explode(' ', $alumno['apellidos'])[0] . '@gmail.com');
            //DNi
            $dni = $alumno['dni'] ?? random_int(10000000, 99999999) . chr(rand(65, 90));
            //Usuario y contraseña
            $usuario = $alumno['usuario'] ?? strtolower($alumno['nombre'] . substr(explode(' ', $alumno['apellidos'])[0], 0, 2) . ($i + 1));
            $plainPassword = $alumno['password'] ?? 'password' . ($i + 1);
            $hashedPassword = Hash::make($plainPassword);
            //Nivel FK , Profesor FK y ROL FK
            $idnivel = $alumno['idnivel'] ?? (($i % 4) + 1);
            $idprofesor = $alumno['idprofesor'] ?? (($i % 4) + 1);
            $idrol = 3;
            $timestamp = Carbon::now();

            DB::table('usuario')->insert([
                'usuario' => $usuario,
                'contraseña' => $hashedPassword,
                'email' => $email,
                'dni' => $dni,
                'idrol' => $idrol,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table('alumno')->insert([
                'nombre' => $alumno['nombre'],
                'apellidos' => $alumno['apellidos'],
                'email' => $email,
                'dni' => $dni,
                'usuario' => $usuario,
                'contraseña' => $hashedPassword,
                'idnivel' => $idnivel,
                'idrol' => $idrol,
                'idprofesor' => $idprofesor,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}

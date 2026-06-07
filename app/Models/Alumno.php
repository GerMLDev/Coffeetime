<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Nivel;
use App\Models\Profesor;

// Modelo de alumno con nivel y profe
class Alumno extends Model
{
    protected $table = "alumno";
     protected $hidden = [
    'contraseña',
    'remember_token',
];

//Recuperar nivelees y profesores (funcion Recargar())
    public function nivel(){
        return $this->belongsTo(Nivel::class, 'idnivel');

    }
    public function profe(){
        return $this->belongsTo(Profesor::class, 'idprofesor');

    }

    // Obtiene el alumno con su profe y nivel por ID
    public function obtenerAlumno($id)
    {
        return self::select(
            'alumno.*',
            DB::raw("CONCAT(profesor.nombre_profesor, ' ', profesor.apellidos_profesor) AS PROFESOR"),
            DB::raw("nivel.nivel AS NIVEL")
        )
        ->join('profesor', 'alumno.idprofesor', '=', 'profesor.id')
        ->join('nivel', 'alumno.idnivel', '=', 'nivel.id')
        ->where('alumno.id', $id)
        ->first();
    }


    // Lista los alumnos de un profe con su nivel buscando por ID del profesor
    public function obtenerProfesordeAlumno($id)
    {
        return self::select(
            DB::raw("CONCAT(alumno.nombre, ' ', alumno.apellidos) AS ALUMNO"),
            DB::raw("nivel.nivel AS NIVEL")
        )
        ->join('nivel', 'alumno.idnivel', '=', 'nivel.id')
        ->where('alumno.idprofesor', $id)
        ->get();

    }

    // Cuenta cuántos alumnos hay por nivel (dashboard)
    static public function getAlumnosPorNivel(){
        return self::select(
            'nivel.nivel',
            DB::raw("COUNT(alumno.nombre) AS cantidad")
        )
        ->join('nivel', 'alumno.idnivel', '=', 'nivel.id')
        ->groupBy([
            'nivel.nivel'])
        ->get();
    }

    // Cuenta alumnos por cada profe (dashboardProfe)
    static public function getAlumnosPorProfesor(){
        return self::select(
        DB::raw("CONCAT(nombre_profesor, ' ', apellidos_profesor) AS PROFESOR"),
        DB::raw("COUNT(*) AS cantidad"))
        ->join('profesor','profesor.id','=','alumno.idprofesor')
        ->groupBy(['PROFESOR'])
        ->get();


       }
}

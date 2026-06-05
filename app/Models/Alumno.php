<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Nivel;
use App\Models\Profesor;

class Alumno extends Model
{
    protected $table = "alumno";

//Funciones para recuperar nivelees y profesores (funcion Recargar())
    public function nivel(){
        return $this->belongsTo(Nivel::class, 'idnivel');

    }
    public function profe(){
        return $this->belongsTo(Profesor::class, 'idprofesor');

    }

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

    static public function getAlumnosPorProfesor(){
        return self::select(

        DB::raw("CONCAT(nombre_profesor, ' ', apellidos_profesor) AS PROFESOR"),
        DB::raw("COUNT(*) AS cantidad"))
        ->join('profesor','profesor.id','=','alumno.idprofesor')
        ->groupBy(['PROFESOR'])
        ->get();


       }
}

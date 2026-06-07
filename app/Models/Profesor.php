<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Nivel;

// Modelo de profe con nivel asignado
class Profesor extends Model
{
    protected $table = "profesor";
     protected $hidden = [
    'contrasena_prof',
    'remember_token',
];
    //Recuperar niveles

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'idnivel');
    }
    //Recuperar profesor

    public function obtenerProfesor($id)
    {
        return self::select('profesor.*')
        ->where('profesor.id', $id)
        ->first();

    }



}

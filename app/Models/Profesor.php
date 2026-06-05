<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Nivel;

class Profesor extends Model
{
    protected $table = "profesor";
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable = ['idalumno', 'idevento', 'fecha_inscripcion'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'idalumno');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idevento');
    }
}


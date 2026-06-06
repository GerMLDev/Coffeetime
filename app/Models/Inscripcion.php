<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo de inscripción conectando alumno y evento
class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable = ['idalumno', 'idevento', 'fecha_inscripcion'];


    //Recuperarr alumnos y eventos
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'idalumno');
    }

    // Relación con el evento inscrito
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idevento');
    }
}


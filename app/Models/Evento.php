<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo de evento con profe, nivel e inscripciones
class Evento extends Model
{
    protected $table = "eventos";

    protected $fillable = [
        'titulo',
        'fecha',
        'hora',
        'enlace',
        'idnivel',
        'idprofesor'
    ];

    // Relación con el nivel del evento
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'idnivel');
    }

    // Relación con el profe del evento
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'idprofesor');
    }

    //Inscripciones para eventos
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'idevento');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo de recurso con profe y nivel
class Recurso extends Model
{
    protected $table = "recursos";
    protected $fillable = ['titulo', 'tipo', 'enlace', 'idprofesor'];


    //Recuperar niveles y profesores
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'idprofesor');
    }
    // Relaciona al nivel con recurso
    public function nivel()
{
    return $this->belongsTo(Nivel::class, 'idnivel');
}
}

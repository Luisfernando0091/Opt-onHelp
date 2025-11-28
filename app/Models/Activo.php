<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $fillable = [
        'nombre', 'tipo', 'marca', 'modelo', 'serial', 'categoria',
        'categoria', 'caracteristica', 'descripcion',
        'estado', 'asignado_a','ubicacion_id',
    ];

    // Relación con historial
 public function historial()
{
    return $this->hasMany(\App\Models\HistorialActivo::class, 'activo_id');
}


    // Relación con usuario asignado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }
     public function ubicacion()
    {
       // return $this->belongsTo(Ubicacion::class);
          return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}

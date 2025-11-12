<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'usuario_id',
        'tecnico_id',
        'categoria_id',
        'fecha_reporte',
        'fecha_cierre',
        'solucion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}

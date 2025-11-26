<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialActivo extends Model
{
    protected $fillable = [
        'activo_id', 'user_id', 'accion', 'detalle'
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

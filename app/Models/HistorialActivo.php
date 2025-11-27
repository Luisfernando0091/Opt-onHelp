<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activo;
use App\Models\User;

class HistorialActivo extends Model
{
    protected $table = 'historial_activos';

    protected $fillable = [
        'activo_id',
        'user_id',
        //'accion',
        'observacion',
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

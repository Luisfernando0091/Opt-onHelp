<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BssCinc extends Model
{
    use HasFactory;

    // 🔹 Forzar el nombre correcto de la tabla
    protected $table = 'bss_cinc';

    // 🔹 Clave primaria personalizada
    protected $primaryKey = 'CODIGO';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CODIGO',
        'nombre_caso',
    ];
}

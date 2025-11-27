<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones'; // por si el plural no es automático
    protected $fillable = ['nombre']; // campos permitidos para insert/update
}

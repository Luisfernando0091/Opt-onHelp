<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaInventario extends Model
{
     protected $table = "categoria_inventario";
     protected $fillable = ['nombre', 'descripcion'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
 use HasFactory;
 protected $fillable = [
    "incidente_id",
    "usuario_id",
    "ruta",
    "tipo",
 ]; 
 
          // 🔗 Un archivo pertenece a un usuario (quien lo sube)

  public function usuario()
        {
            return $this->belongsTo(User::class , 'usuario_id');

        }
         // 🔗 Un archivo pertenece a un incidente (al que está adjunto)
         public function incidentes()
     {
         return $this->hasMany(Incidente::class);
     }
}

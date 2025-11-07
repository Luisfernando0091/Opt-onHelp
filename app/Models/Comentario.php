<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = [
    
      
        'incidente_id',
        'usuario_id',
        'comentario',
        'tipo',
    ];
    public function incidente()
    {
        return $this->belongsTo(Incidente::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}

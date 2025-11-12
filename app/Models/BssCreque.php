<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BssCreque extends Model
{
    use HasFactory;

    protected $table = 'bss_creque';
    protected $primaryKey = 'CODIGO';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CODIGO',
        'nombre_caso',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

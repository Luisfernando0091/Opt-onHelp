<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 👇 Importante para usar Spatie Roles
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'LastName',   // ✅ tu nuevo campo
        'email',
        'password',
        'phone',      // opcional si existe
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Relaciones personalizadas (no cambian)
    public function incidentesReportados()
    {
        return $this->hasMany(Incidente::class, 'usuario_id');
    }

    public function incidentesAsignados()
    {
        return $this->hasMany(Incidente::class, 'tecnico_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }
}

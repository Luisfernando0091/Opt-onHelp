<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens; // ✅ ahora sí existirá

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',   // 👈 Agregamos el campo de rol (admin, tecnico, usuario)
        'phone',  // 👈 Si quieres guardar teléfono
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Relaciones con otros modelos

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
public function roleData()
{
    return $this->belongsTo(Role::class, 'role', 'id');
}

}

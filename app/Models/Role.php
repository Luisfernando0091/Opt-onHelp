<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; // nombre de tu tabla

    protected $fillable = [
        'name',
        'guard_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'id');
    }
}

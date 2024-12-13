<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuari extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'rol_id'
    ];

    public function reserves()
    {
        return $this->hasMany(Reservas::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

}

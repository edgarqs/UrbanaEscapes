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
        'dni',
        'rol_id',
        'hotel_id'
    ];

    public function reserves()
    {
        return $this->hasMany(Reservas::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->rol && $this->rol->nom === $role;
    }

}

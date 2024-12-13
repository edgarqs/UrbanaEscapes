<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuari extends Model
{
    use HasFactory;

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

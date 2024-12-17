<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [
        'nom'
    ];

    public function usuaris()
    {
        return $this->hasMany(Usuari::class);
    }
}

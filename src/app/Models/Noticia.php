<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticies';

    protected $fillable = [
        'titol',
        'descripcio_curta',
        'descripcio_llarga',
        'publicada',
    ];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'noticies_hotel');
    }

    public function fotos()
    {
        return $this->hasMany(NoticiaFoto::class);
    }
}

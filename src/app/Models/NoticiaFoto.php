<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiaFoto extends Model
{
    use HasFactory;

    protected $table = 'noticies_foto';

    protected $fillable = [
        'noticia_id',
        'foto',
    ];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelSetting extends Model
{
    use HasFactory;

    protected $table = 'hotel_settings';
    protected $fillable = ['hotel_id', 'secciones_visibles', 'secciones_orden', 'noticias_cantidad', 'feedbacks_cantidad'];

    protected $casts = [
        'secciones_visibles' => 'array',
        'secciones_orden' => 'array',
    ];

    public function hotel()
    {   
        return $this->belongsTo(Hotel::class);
    }
}

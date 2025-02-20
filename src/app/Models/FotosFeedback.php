<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_id',
        'url',
    ];
}

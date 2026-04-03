<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table = 'footer';

    protected $fillable = [
        'title_en',
        'title_es',
        'subtitle_en',
        'subtitle_es',
        'image_url',
    ];
}

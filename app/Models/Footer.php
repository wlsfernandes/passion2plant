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

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'es' ? $this->title_es : $this->title_en;
    }

    public function getSubtitleAttribute()
    {
        return app()->getLocale() === 'es' ? $this->subtitle_es : $this->subtitle_en;
    }
}

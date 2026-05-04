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
        return app()->getLocale() === 'es' ? $this->cleanText($this->title_es) : $this->cleanText($this->title_en);
    }

    public function getSubtitleAttribute()
    {
        return app()->getLocale() === 'es' ? $this->cleanText($this->subtitle_es) : $this->cleanText($this->subtitle_en);
    }

    protected function cleanText(?string $value): string
    {
        return html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

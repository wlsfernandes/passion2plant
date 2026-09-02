<?php

namespace App\Models;

use App\Traits\ConvertsToEmbedUrl;
use Illuminate\Database\Eloquent\Model;

class SectionVideo extends Model
{
    use ConvertsToEmbedUrl;

    protected $fillable = [
        'section_id',
        'image_url',
        'video_url',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getEmbedUrlAttribute()
    {
        return $this->convertToEmbedUrl($this->video_url);
    }
}

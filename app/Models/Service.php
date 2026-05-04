<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'content_en',
        'content_es',
        'image_url',
        'external_link',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /*
       |--------------------------------------------------------------------------
       | Boot
       |--------------------------------------------------------------------------
       */

    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = static::generateUniqueSlug($service->title_en);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title_en')) {
                $service->slug = static::generateUniqueSlug(
                    $service->title_en,
                    $service->id
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Slug Generator
    |--------------------------------------------------------------------------
    */

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
{
    $cleanTitle = html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8');

    $slug = Str::slug($cleanTitle);
    $original = $slug ?: 'item';
    $counter = 1;

    while (
        static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
    ) {
        $slug = "{$original}-{$counter}";
        $counter++;
    }

    return $slug;
}

    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'es'
            ? $this->title_es
            : $this->title_en;
    }

    public function getContent(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'es'
            ? $this->content_es
            : $this->content_en;
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }
}

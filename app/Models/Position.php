<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Position extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'content_en',
        'content_es',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'image_url',
        'file_url_en',
        'file_url_es',
        'external_link',
    ];

    protected $casts = [
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('publish_start_at')
                    ->orWhere('publish_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Slug Handling
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($position) {
            $position->slug = self::generateUniqueSlug($position->title_en);
        });

        static::updating(function ($position) {
            if ($position->isDirty('title_en')) {
                $position->slug = self::generateUniqueSlug($position->title_en);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $cleanTitle = html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8');
        $slug = Str::slug($cleanTitle);
        $original = $slug ?: 'item';
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (Optional but Recommended)
    |--------------------------------------------------------------------------
    */

    public function getTitle(): string
    {
        $value = app()->getLocale() === 'es'
            ? ($this->title_es ?: $this->title_en)
            : $this->title_en;

        return $value;
    }

    public function getContent(): string
    {
        $value = app()->getLocale() === 'es'
            ? ($this->content_es ?: $this->content_en)
            : $this->content_en;

        return $value;
    }

    /**
     * Clean HTML tags and decode entities
     */
    public function getFileUrl(): ?string
    {
        return app()->getLocale() === 'es'
            ? ($this->file_url_es ?: $this->file_url_en)
            : ($this->file_url_en ?: $this->file_url_es);
    }
}

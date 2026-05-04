<?php

namespace App\Models;

use App\Models\Concerns\HasTextLimits;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use Auditable, HasFactory, HasTextLimits;

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
        'external_link_button_text',
    ];

    protected $casts = [
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function getTitle(): string
    {
        $value = app()->getLocale() === 'es'
            ? ($this->title_es ?: $this->title_en)
            : $this->title_en;

        return $this->cleanText($value);
    }

    public function getContent(): string
    {
        $value = app()->getLocale() === 'es'
            ? ($this->content_es ?: $this->content_en)
            : $this->content_en;

        return $this->cleanText($value);
    }

    /**
     * Clean HTML tags and decode entities
     */
    protected function cleanText(?string $value): string
    {
        return html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Boot method to handle slug generation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Blog $blog) {
            $blog->slug = static::generateUniqueSlug($blog->title_en);
        });

        static::updating(function (Blog $blog) {
            if ($blog->isDirty('title_en')) {
                $blog->slug = static::generateUniqueSlug(
                    $blog->title_en,
                    $blog->id
                );
            }
        });
    }

    protected static function booted()
    {
        static::updated(fn () => \Log::info('BLOG updated fired'));
    }

    /**
     * Generate a unique slug based on the English title.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
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

    /**
     * Scope: only currently visible blogs.
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

    public function hasDownloadFile(): bool
    {
        return ! empty($this->getFileUrl());
    }

    public function getFileUrl(): ?string
    {
        return app()->getLocale() === 'es'
            ? ($this->file_url_es ?: $this->file_url_en)
            : ($this->file_url_en ?: $this->file_url_es);
    }
}

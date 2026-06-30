<?php

namespace App\Models;

use App\Models\Concerns\HasTextLimits;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Auditable, HasFactory, HasTextLimits;

    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'content_en',
        'content_es',
        'event_date',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'image_url',
        'file_url_en',
        'file_url_es',
        'external_link',
        'external_link_button_text',
        'video_url',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function getTitle(): string
    {
        return app()->getLocale() === 'es'
            ? ($this->title_es ?: $this->title_en)
            : $this->title_en;
    }

    public function getContent(): string
    {
        return app()->getLocale() === 'es'
            ? ($this->content_es ?: $this->content_en)
            : $this->content_en;
    }

    /**
     * Boot method to handle slug generation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Event $event) {
            $event->slug = static::generateUniqueSlug($event->title_en);
        });

        static::updating(function (Event $event) {
            if ($event->isDirty('title_en')) {
                $event->slug = static::generateUniqueSlug(
                    $event->title_en,
                    $event->id
                );
            }
        });
    }

    protected static function booted()
    {
        static::updated(fn () => \Log::info('EVENT updated fired'));
    }

    /**
     * Generate a unique slug based on the English title.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        // 🔥 Remove HTML tags first
        $cleanTitle = trim(strip_tags($title));

        // Optional: decode HTML entities (&nbsp;, etc.)
        $cleanTitle = html_entity_decode($cleanTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Generate slug
        $slug = Str::slug($cleanTitle);

        // Fallback if empty (important!)
        if (empty($slug)) {
            $slug = 'item';
        }

        $original = $slug;
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
     * Scope: only currently visible events.
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

    public function getVideoEmbedUrlAttribute(): ?string
    {
        $url = $this->video_url;

        if (empty($url)) {
            return null;
        }

        if (
            str_contains($url, 'youtube.com/embed') ||
            str_contains($url, 'player.vimeo.com')
        ) {
            return $url;
        }

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            preg_match(
                '/(youtu\.be\/|v=|embed\/|shorts\/)([^\&\?\/]+)/',
                $url,
                $matches
            );

            if (! empty($matches[2])) {
                return 'https://www.youtube.com/embed/'.$matches[2];
            }

            return null;
        }

        if (str_contains($url, 'vimeo.com')) {
            preg_match('/vimeo\.com\/(\d+)/', $url, $matches);

            if (! empty($matches[1])) {
                return 'https://player.vimeo.com/video/'.$matches[1];
            }

            return null;
        }

        return null;
    }

    public function hasDirectVideoFile(): bool
    {
        return ! empty($this->video_url)
            && preg_match('/\.(mp4|webm|ogg)$/i', $this->video_url) === 1;
    }
}

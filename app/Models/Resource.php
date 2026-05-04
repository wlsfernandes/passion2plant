<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'title_en',
        'title_es',
        'description_en',
        'description_es',
        'file_url_en',
        'file_url_es',
        'external_link',
        'is_published',
        'image_url',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only published resources.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Full logging handled in controllers via SystemLogger.
     */
    protected static function booted()
    {
        static::updated(fn () => \Log::info('RESOURCE updated fired'));
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{'title_'.$locale} ?? $this->title_en);
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{'description_'.$locale} ?? $this->description_en);
    }

    protected function cleanText(?string $value): string
    {
        return html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    public function getFileUrlAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->{'file_url_'.$locale} ?? $this->file_url_en;
    }
}

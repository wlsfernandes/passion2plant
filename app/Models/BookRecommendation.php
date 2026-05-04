<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRecommendation extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'title_en',
        'title_es',
        'description_en',
        'description_es',
        'image_url',
        'external_link',
    ];

    /**
     * Localized title accessor
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{'title_'.$locale} ?? $this->title_en);
    }

    /**
     * Localized description accessor
     */
    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{'description_'.$locale} ?? $this->description_en);
    }

    protected function cleanText(?string $value): string
    {
        return html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Lightweight observability
     */
    protected static function booted()
    {
        static::updated(fn () => \Log::info('BOOK RECOMMENDATION updated'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'description_en',
        'description_es',
        'amount',
        'currency',
        'image_url',
        'is_published',
    ];

    /**
     * Get title based on current locale
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{'title_'.$locale} ?? $this->title_en);
    }

    /**
     * Get description based on current locale
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
     * Scope: only published memberships
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}

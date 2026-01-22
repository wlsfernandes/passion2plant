<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Section extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'page_id',
        'sort_order',
        'title_en',
        'title_es',
        'content_en',
        'content_es',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Parent page
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Scope: only visible sections
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get title based on current locale
     */
    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->{'title_' . $locale}
            ?? $this->title_en;
    }

    /**
     * Get content based on current locale
     */
    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->{'content_' . $locale}
            ?? $this->content_en;
    }

    /**
     * Default ordering by sort_order
     */
    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('sort_order');
        });
    }
}

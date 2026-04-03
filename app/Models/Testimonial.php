<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'name',
        'role',
        'content_en',
        'content_es',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only published testimonials.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Controller handles full SystemLogger logging.
     */
    protected static function booted()
    {
        static::updated(fn () => \Log::info('TESTIMONIAL updated fired'));
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();

        $field = "content_{$locale}";

        return $this->{$field} ?? $this->content_en ?? '';
    }
}

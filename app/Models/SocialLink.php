<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'platform',
        'url',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'platform' => SocialPlatform::class, // ✅ enum casting
    ];

    /**
     * Scope: only active social links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered social links.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Convenience: icon class from enum.
     */
    public function getIconAttribute(): string
    {
        return $this->platform?->icon() ?? '';
    }

    /**
     * Convenience: label from enum.
     */
    public function getLabelAttribute(): string
    {
        return $this->platform?->label() ?? '';
    }

    /**
     * Lightweight observability.
     * Full logging handled in controller.
     */
    protected static function booted()
    {
        static::updated(fn () => \Log::info('SOCIAL LINK updated fired'));
    }
}

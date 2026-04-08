<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educator extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'external_link',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only published educators.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * System observability
     */
    protected static function booted()
    {
        static::updated(fn () => \Log::info('EDUCATOR updated fired'));
    }
}

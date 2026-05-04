<?php

namespace App\Models;

use App\Models\Concerns\HasTextLimits;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use Auditable, HasFactory, HasTextLimits;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'slug',
        'role',
        'content_en',
        'content_es',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /* ---------------- Relations ---------------- */

    public function sectors()
    {
        return $this->belongsToMany(Sector::class)->withTimestamps();
    }

    /* ---------------- Slug logic (FIXED) ---------------- */

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Team $team) {
            $fullName = $team->getFullNameForSlug();
            $team->slug = static::generateUniqueSlug($fullName);
        });

        static::updating(function (Team $team) {
            if ($team->isDirty('first_name') || $team->isDirty('last_name')) {
                $fullName = $team->getFullNameForSlug();
                $team->slug = static::generateUniqueSlug($fullName, $team->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        // ✅ Clean EVERYTHING here (single source of truth)
        $cleanTitle = html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8');

        // Normalize spacing
        $cleanTitle = trim(preg_replace('/\s+/', ' ', $cleanTitle));

        $slug = Str::slug($cleanTitle);

        // Fallback if empty (e.g. title was only HTML)
        $original = $slug ?: 'team';
        $slug = $original;

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

    protected function getFullNameForSlug(): string
    {
        $fullName = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        // fallback if both empty
        return $fullName ?: ($this->name ?? 'team');
    }

    /* ---------------- Scopes ---------------- */

    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /* ---------------- Accessors ---------------- */

    public function getDisplayNameAttribute()
    {
        if ($this->first_name || $this->last_name) {
            return trim($this->first_name.' '.$this->last_name);
        }

        return $this->name;
    }
}

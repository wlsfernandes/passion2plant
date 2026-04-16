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

    /* ---------------- Slug logic (unchanged) ---------------- */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Team $team) {
            $cleanName = strip_tags($team->name);
            $team->slug = static::generateUniqueSlug($cleanName);
        });

        static::updating(function (Team $team) {
            if ($team->isDirty('name')) {
                $cleanName = strip_tags($team->name);
                $team->slug = static::generateUniqueSlug($cleanName, $team->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
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

    /* ---------------- Scopes ---------------- */

    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->first_name || $this->last_name) {
            return trim($this->first_name.' '.$this->last_name);
        }

        return $this->name;
    }
}

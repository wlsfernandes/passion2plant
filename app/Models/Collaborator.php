<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collaborator extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'description_en',
        'description_es',
        'start_date',
        'end_date',
        'is_published',
        'external_link',
        'image_url',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    /*
  |--------------------------------------------------------------------------
  | Relationships
  |--------------------------------------------------------------------------
  */

    public function images()
    {
        return $this->hasMany(CollaboratorImage::class)->orderBy('position');
    }

    /*
  |--------------------------------------------------------------------------
  | Slug handling (same pattern as Page)
  |--------------------------------------------------------------------------
  */

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Collaborator $collaborator) {
            $collaborator->slug = static::generateUniqueSlug($collaborator->title_en);
        });

        static::updating(function (Collaborator $collaborator) {
            if ($collaborator->isDirty('title_en')) {
                $collaborator->slug = static::generateUniqueSlug(
                    $collaborator->title_en,
                    $collaborator->id
                );
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $cleanTitle = html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8');
        $slug = Str::slug($cleanTitle);
        $original = $slug ?: 'item';
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

    /*
  |--------------------------------------------------------------------------
  | Locale-aware accessors
  |--------------------------------------------------------------------------
  */

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

    /*
  |--------------------------------------------------------------------------
  | Scopes
  |--------------------------------------------------------------------------
  */

    /**
     * Scope: only visible team members.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    public function getBannerUrlAttribute(): string
    {
        return $this->image_url
            ? route('admin.images.preview', [
                'model' => 'collaborators',
                'id' => $this->id,
            ])
            : asset('assets/frontend/img/banner/breadcumd-bg.jpg');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'title_en',
    'title_es',
    'description_en',
    'description_es',
    'start_date',
    'end_date',
    'is_published',
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
    return $this->hasMany(ProjectImage::class)->orderBy('position');
  }

  /*
  |--------------------------------------------------------------------------
  | Accessors (Locale-aware)
  |--------------------------------------------------------------------------
  */

  public function getTitleAttribute(): string
  {
    $locale = app()->getLocale();

    return $this->{'title_' . $locale}
      ?? $this->title_en;
  }

  public function getDescriptionAttribute(): ?string
  {
    $locale = app()->getLocale();

    return $this->{'description_' . $locale}
      ?? $this->description_en;
  }

  /*
  |--------------------------------------------------------------------------
  | Scopes
  |--------------------------------------------------------------------------
  */

  public function scopePublished($query)
  {
    return $query->where('is_published', true);
  }

  public function scopeActive($query)
  {
    return $query->where(function ($q) {
      $q->whereNull('start_date')
        ->orWhere('start_date', '<=', now());
    })->where(function ($q) {
      $q->whereNull('end_date')
        ->orWhere('end_date', '>=', now());
    });
  }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaType extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'is_active',
  ];

  protected static function booted()
  {
    static::creating(function (MediaType $type) {
      $type->slug = Str::slug($type->name);
    });
  }

  public function media()
  {
    return $this->hasMany(Media::class);
  }
}

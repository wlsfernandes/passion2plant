<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'sort_order',

        'title_en',
        'title_es',

        'content_en',
        'content_es',

        'image_url',
        'link_image',

        'external_link',
        'button_text',
        'button_position',
        'button_color',

        'type',
        'layout',
        'feature_type',
        'carousel_type',

        'is_published',

        // ✅ NEW STYLE FIELDS
        'margin_top',
        'margin_bottom',
        'padding_top',
        'padding_bottom',

        'background_color',
        'text_color',
        'background_image_url',

        'container', // boxed or full
        'custom_class',
    ];

    protected $casts = [
        'is_published' => 'boolean',

        // spacing as integers
        'margin_top' => 'integer',
        'margin_bottom' => 'integer',
        'padding_top' => 'integer',
        'padding_bottom' => 'integer',
    ];

    protected $attributes = [
        'sort_order' => 0,

        // sensible defaults
        'margin_top' => 0,
        'margin_bottom' => 0,
        'padding_top' => 0,
        'padding_bottom' => 0,

        'background_color' => null,
        'text_color' => null,
        'background_image_url' => null,

        'container' => 'container', // or 'container-fluid'
    ];
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function cards()
    {
        return $this->hasMany(SectionCard::class)->orderBy('sort_order');
    }

    public function images()
    {
        return $this->hasMany(SectionImage::class)->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Localization Helpers
    |--------------------------------------------------------------------------
    */

    public function getTitle()
    {
        return $this->{'title_'.app()->getLocale()};
    }

    public function getContent()
    {
        return $this->{'content_'.app()->getLocale()};
    }

    public function getButtonText()
    {
        return $this->button_text ?: 'Learn More';
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort_order');
        });

        static::creating(function ($section) {

            // If sort_order is not defined or zero
            if (! $section->sort_order) {

                $maxOrder = self::where('page_id', $section->page_id)
                    ->max('sort_order');

                $section->sort_order = $maxOrder ? $maxOrder + 1 : 1;
            }

        });
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

    /* Styles   |--------------------------------------------------------------------------
    */
    public function getStyleAttribute()
    {
        $styles = [];

        if ($this->margin_top) {
            $styles[] = "margin-top: {$this->margin_top}px";
        }

        if ($this->margin_bottom) {
            $styles[] = "margin-bottom: {$this->margin_bottom}px";
        }

        if ($this->padding_top) {
            $styles[] = "padding-top: {$this->padding_top}px";
        }

        if ($this->padding_bottom) {
            $styles[] = "padding-bottom: {$this->padding_bottom}px";
        }

        if ($this->background_color) {
            $styles[] = "background-color: {$this->background_color}";
        }

        if ($this->text_color) {
            $styles[] = "color: {$this->text_color}";
        }

        if ($this->background_image_url) {

            $imageUrl = route('admin.images.previewField', [
                'model' => 'sections',
                'id' => $this->id,
                'field' => 'background_image_url',
            ]);

            $styles[] = "background-image: url('{$imageUrl}')";
            $styles[] = 'background-size: cover';
            $styles[] = 'background-position: center';
            $styles[] = 'background-repeat: no-repeat';
        }

        return implode('; ', $styles);
    }
}

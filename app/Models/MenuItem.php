<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'link',
        'order',
        'parent_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Parent menu item
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Submenu items
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Return title based on current locale
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();

        return $this->cleanText($this->{"title_{$locale}"} ?? $this->title_en);
    }

    protected function cleanText(?string $value): string
    {
        return html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Scope main menu items
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public static function footerMenu()
    {
        $menu = self::main()
            ->with('children')
            ->orderBy('order')
            ->get();

        return self::flatten($menu);
    }

    private static function flatten($items)
    {
        $flat = collect();

        foreach ($items as $item) {
            $flat->push($item);

            if ($item->children->count()) {
                $flat = $flat->merge(self::flatten($item->children));
            }
        }

        return $flat; // ✅ THIS WAS MISSING
    }
}

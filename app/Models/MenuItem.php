<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Direct submenu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order');
    }

    /**
     * Submenu items with every descendant eagerly loaded.
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Collect IDs of all descendants.
     */
    public function getDescendantIds(): array
    {
        $this->loadMissing('childrenRecursive');

        return self::collectDescendantIds($this->childrenRecursive);
    }

    /**
     * @param  Collection<int, MenuItem>  $items
     * @return list<int>
     */
    private static function collectDescendantIds(Collection $items): array
    {
        $ids = [];

        foreach ($items as $child) {
            $ids[] = $child->id;
            array_push($ids, ...self::collectDescendantIds($child->childrenRecursive));
        }

        return $ids;
    }

    /**
     * Build a flat ordered array of [id => label] for the parent selector.
     * Pass $exclude to omit that item and all its descendants.
     */
    public static function buildParentOptions(?self $exclude = null): array
    {
        $items = self::whereNull('parent_id')
            ->with('childrenRecursive')
            ->orderBy('order')
            ->get();

        $forbidden = $exclude
            ? array_merge([$exclude->id], $exclude->getDescendantIds())
            : [];

        return self::flattenParentOptions($items, $forbidden);
    }

    /**
     * @param  Collection<int, MenuItem>  $items
     * @param  list<int>  $forbidden
     * @return array<int, string>
     */
    private static function flattenParentOptions(Collection $items, array $forbidden, int $depth = 0): array
    {
        $options = [];
        $prefix = str_repeat('— ', $depth);

        foreach ($items as $item) {
            if (in_array($item->id, $forbidden, true)) {
                continue;
            }

            $options[$item->id] = $prefix.$item->title_en;

            if ($item->childrenRecursive->isNotEmpty()) {
                $options += self::flattenParentOptions($item->childrenRecursive, $forbidden, $depth + 1);
            }
        }

        return $options;
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
            ->with('childrenRecursive')
            ->orderBy('order')
            ->get();

        return self::flatten($menu);
    }

    private static function flatten($items)
    {
        $flat = collect();

        foreach ($items as $item) {
            $flat->push($item);

            if ($item->childrenRecursive->isNotEmpty()) {
                $flat = $flat->merge(self::flatten($item->childrenRecursive));
            }
        }

        return $flat; // ✅ THIS WAS MISSING
    }
}

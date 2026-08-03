<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
        'is_enabled',
        'primary_color',
        'secondary_color',
        'accent_color',
        'dark_color',
        'light_color',
        'body_color',
        'header_text_mode',
        'body_font',
        'heading_font',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /** Default values matching the existing SCSS variables. */
    public const DEFAULTS = [
        'is_enabled'       => false,
        'primary_color'    => '#4BAF47',
        'secondary_color'  => '#938A42',
        'accent_color'     => '#ED8A19',
        'dark_color'       => '#24231D',
        'light_color'      => '#F8F7F0',
        'body_color'       => '#FFFFFF',
        'header_text_mode' => 'light',
        'body_font'        => 'default',
        'heading_font'     => 'default',
    ];

    /**
     * Approved body text font options.
     * Keys are stored in the database; values are the resolved CSS font-family string
     * (null means "use site default — no variable output").
     */
    public const BODY_FONTS = [
        'default'       => null,
        'montserrat'    => "'Montserrat', sans-serif",
        'source-sans-3' => "'Source Sans 3', sans-serif",
    ];

    /**
     * Approved heading font options.
     * Keys are stored in the database; values are the resolved CSS font-family string
     * (null means "use site default — no variable output").
     */
    public const HEADING_FONTS = [
        'default'          => null,
        'montserrat'       => "'Montserrat', sans-serif",
        'dm-serif-display' => "'DM Serif Display', serif",
    ];

    /** Returns the singleton record, creating it with defaults if absent. */
    public static function current(): self
    {
        return static::first() ?? static::create(static::DEFAULTS);
    }

    /** Prevent more than one settings row. */
    protected static function booted(): void
    {
        static::creating(function () {
            if (static::count() > 0) {
                throw new \RuntimeException('Only one theme settings record is allowed.');
            }
        });
    }
}

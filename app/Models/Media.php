<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $table = 'media';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'disk',
        'path',
        'folder',
        'filename',
        'original_name',
        'mime_type',
        'extension',
        'size',
        'title',
        'alt_text',
        'uploaded_by',
    ];

    /**
     * Default attributes
     */
    protected $attributes = [
        'disk' => 's3',
    ];

    /**
     * Relationships
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Helpers
     */

    /**
     * Get full URL (optional helper)
     */
    public function getUrlAttribute(): string
    {
        return \Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Get file name nicely
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->title
            ?? $this->original_name
            ?? $this->filename
            ?? 'file';
    }
}

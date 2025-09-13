<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get CMS page by slug
     */
    public static function getBySlug($slug)
    {
        return static::where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
    }

    /**
     * Get all active CMS pages
     */
    public static function getActivePages()
    {
        return static::where('is_active', true)
                    ->orderBy('title')
                    ->get();
    }
}

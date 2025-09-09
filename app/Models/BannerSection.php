<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'language',
        'image',
        'title',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the language name
     */
    public function getLanguageNameAttribute()
    {
        return $this->language === 'hi' ? 'Hindi' : 'English';
    }

    /**
     * Scope to filter by language
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }
}

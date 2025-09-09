<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestOfHonour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'language',
        'season_name',
        'guest_name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'language',
        'title',
        'number_of_participants',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'number_of_participants' => 'integer',
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
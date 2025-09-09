<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Process extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'language',
        'title',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

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

    /**
     * Get the steps for the process.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(ProcessStep::class);
    }
}

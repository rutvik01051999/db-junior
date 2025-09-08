<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'participation_categories_1',
        'participation_categories_2',
        'participation_categories_3',
        'participation_categories_4',
        'timeline_1',
        'timeline_2',
        'timeline_3',
        'timeline_4',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

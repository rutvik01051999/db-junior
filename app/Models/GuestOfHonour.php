<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestOfHonour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'season_name',
        'guest_name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
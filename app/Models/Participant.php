<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'number_of_participants',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'number_of_participants' => 'integer',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $table = 'certi_student';

    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'batch_no',
        'created_date',
    ];

    protected $casts = [
        'created_date' => 'datetime',
    ];

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessStep extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'process_id',
        'content',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the process that owns the step.
     */
    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }
}
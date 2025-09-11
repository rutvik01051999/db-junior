<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RazorpayPaymentResponse extends Model
{
    protected $table = 'razorpay_payment_response';
    
    protected $fillable = [
        'mobile',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'status',
        'date',
    ];
    
    protected $casts = [
        'create_date' => 'datetime',
        'update_date' => 'datetime',
    ];
    
    public $timestamps = false; // Since we're using custom timestamp columns
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuniorEditor extends Model
{
    use HasFactory;

    protected $table = 'junior_editor_registrations';

    protected $fillable = [
        'parent_name',
        'mobile_number',
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'gender',
        'address',
        'pincode',
        'state',
        'city',
        'school_name',
        'school_telephone',
        'school_class',
        'school_address',
        'delivery_type',
        'amount',
        'pickup_centers',
        'office_address',
        'from_source',
        'mobile_verified',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'birth_date' => 'date',
        'mobile_verified' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Relationship with MobileVerification
     */
    public function mobileVerifications()
    {
        return $this->hasMany(MobileVerification::class, 'mobile_number', 'mobile_number');
    }

    /**
     * Get the latest mobile verification
     */
    public function latestMobileVerification()
    {
        return $this->hasOne(MobileVerification::class, 'mobile_number', 'mobile_number')
            ->latest();
    }
}
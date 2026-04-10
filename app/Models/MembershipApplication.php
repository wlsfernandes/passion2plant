<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $fillable = [
        'amount',
        'interval',

        'email',
        'first_name',
        'last_name',
        'address',
        'country',
        'city',
        'state',
        'postal_code',
        'phone',
        'status',
        'started_at',
        'paid_at',

        'member_id',
        'checkout_session_id',
        'subscription_id',
        'payment_email',

    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'started_at' => 'datetime',
        'paid_at' => 'datetime',
    ];
}

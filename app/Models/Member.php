<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'amount',
        'membership_start_date',
        'membership_end_date',
        'active_status',
        'is_recurring',
    ];
}

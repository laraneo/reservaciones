<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionSlot extends Model
{
    protected $fillable = [
        'session_email', 
        'addon_id',
        'booking_date',
        'booking_time',
        'expiration_date',
        'created_at',
        'updated_at',
        'booking_type',
        'package_id',
        'package_type_id',
        'booking_time2',
    ];


	
}

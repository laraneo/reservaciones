<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddonBooking extends Model
{
    protected $table = 'addon_booking';
    protected $fillable = [
        'addon_id',
        'booking_id',
        'booking_players_id',
        'cant',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingsPerTime extends Model
{
    protected $table = 'settings_PerTime';
    protected $fillable = [
        'bookingUser_maxTimePerDay', 
        'bookingUser_maxTimePerWeek',
        'bookingUser_maxTimePerMonth',
        'bookingGuest_maxTimePerDay',
        'bookingGuest_maxTimePerWeek',
        'bookingGuest_maxTimePerMonth',
    ];
}

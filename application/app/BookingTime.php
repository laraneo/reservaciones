<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
    protected $fillable = [
        'id' ,'day', 'opening_time', 'closing_time', 'is_off_day',
    ];
}

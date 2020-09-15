<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawRequest extends Model
{
    protected $table = 'draw_requests';
    protected $fillable = [
        'draw_id',
        'user_id', 
        'locator',
        'package_id', 
        'draw_address', 
        'draw_instructions', 
        'draw_date',
        'draw_time', 
        'google_calendar_event_id' , 
        'status',
        'priority',
    ];
}

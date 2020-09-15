<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawAddon extends Model
{
    protected $table = 'draw_addon';
    protected $fillable = [
        'addon_id',
        'draw_request_id',
        'draw_players_id',
        'booking_players_id',
        'cant',
    ];
}

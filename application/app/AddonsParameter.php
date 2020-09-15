<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddonsParameter extends Model
{
    protected $fillable = [
        'id', 
        'addon_id', 
        'booking_min', 
        'booking_max',
        'player_min',
        'player_max',
        'guest_min',
        'guest_max',
        'package_id',
    ];

    public function addon()
    {
        return $this->hasOne('App\Addon', 'id', 'addon_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }
}
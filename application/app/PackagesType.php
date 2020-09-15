<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesType extends Model
{
    protected $fillable = [
        'id', 
        'title', 
        'length', 
        'booking_min',
        'booking_max',
        'player_min',
        'player_max',
        'guest_min',
        'guest_max',
        'package_id',
        'status',
        'alias',
    ];

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }
}
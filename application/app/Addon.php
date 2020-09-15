<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'category_id', 'photo_id',
    ];


    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function session_addon()
    {
        return $this->hasMany('App\SessionAddon');
    }

    public function bookings()
    {
        return $this->belongsToMany('App\Booking')->withTimestamps();
    }
}

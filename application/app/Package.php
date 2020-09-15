<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'category_id', 
        'photo_id', 
        'duration',
        'category_type',
        'validation_type',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}

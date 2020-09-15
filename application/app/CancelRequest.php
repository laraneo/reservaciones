<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelRequest extends Model
{
    protected $fillable = [
        'booking_id', 'reason', 'status',
    ];

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }
}

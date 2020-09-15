<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
        'booking_id', 'user_id', 'transaction_id', 'amount', 'payment_method', 'is_refunded', 'is_paid',
    ];

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

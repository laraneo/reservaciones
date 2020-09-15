<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $fillable = [
        'id', 
        'description', 
        'status', 
        'event_id', 
    ];

    public function event()
    {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionAddon extends Model
{
    protected $fillable = [
        'session_email', 
        'addon_id',
        'cant',
        'doc_id',
        'package_id'
    ];

    public function addon()
    {
        return $this->belongsTo('App\Addon');
    }

}

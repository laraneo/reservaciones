<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = [
        'id', 
        'title', 
        'is_active', 
        'package_id',
    ];

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }
}

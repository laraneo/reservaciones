<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawPlayer extends Model
{
    protected $fillable = [
        'id', 
        'draw_request_id', 
        'doc_id', 
        'player_type', 
        'confirmed',
        'confirmed_at',
        'token',
    ];
}

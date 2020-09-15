<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'doc_id', 'player_type', 'session_email',
    ];


	public function playerObject()
    {
        if($this->player_type == 0) //0=user, 1=guest
			return $this->belongsTo('App\User', 'doc_id', 'doc_id');
		else
			return $this->belongsTo('App\Guest', 'doc_id', 'doc_id');
    }
	
	public function first_name()
    {
        if($this->player_type == 0) //0=user, 1=guest
			return $this->playerObject()->first_name;
		else
			return $this->playerObject()->first_name;
    }
	
	public function last_name()
    {
        if($this->player_type == 0) //0=user, 1=guest
			return $this->playerObject()->last_name;
		else
			return $this->playerObject()->last_name;
    }

   /* public function bookings()
    {
        return $this->belongsToMany('App\Booking')->withTimestamps();
    }
	*/
}

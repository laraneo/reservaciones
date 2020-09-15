<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionPlayer extends Model
{
	//protected $table = 'session_players_names' //session_players_names is a view
	
    protected $fillable = [
        'doc_id', 'player_type', 'session_email',
		'first_name', 'last_name','email','phone_number', 'token','package_id'
    ];

	// public function player()
    // {
		// return $this->belongsTo('App\Player');
		
        // // if($this->player_type == 0) //0=user, 1=guest
			// // return $this->belongsTo('App\User', 'doc_id', 'doc_id');
		// // else
			// // return $this->belongsTo('App\Guest', 'doc_id', 'doc_id');
    // }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [
        'user_id', 'locator','package_id', 'booking_address', 'booking_instructions', 'booking_date',
        'booking_time', 'google_calendar_event_id' , 'status', 'court_id', 'booking_time2', 'package_type_id'
    ];

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
	

    public function bookingplayerslist()
    {
		$list = "";
		
		$total = count($this->bookingplayers);
		//$this->addons = $booking->addons;

		if($total>0)
		{
			foreach ($this->bookingplayers as $player)
			{
				if ($list != "") $list = $list . ", ";
				$list =  $list .  $player->PlayerName();
				//$list .= "+";
			}
			//$list=$total;
		}
		
		//$list="K3";
        return $list;
    }
	

										   
										

    public function bookingplayers()
    {
         return $this->hasMany('App\BookingPlayers');
        //return $this->belongsToMany('App\BookingPlayers');
    }
	
    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function addons()
    {
        return $this->belongsToMany('App\Addon')->withTimestamps();
    }

    public function cancel_request()
    {
        return $this->hasOne('App\CancelRequest');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
	
	protected $primaryKey = 'doc_id'; 
	public $incrementing = false;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'doc_id',  'first_name', 'last_name', 'email', 'phone_number', 'plays_month', 'is_active',  'comments', 
    ];

    public function bookingplayers()
    {
        return $this->hasMany('App\BookingPlayers');
    }


    public function isSuspended()
    {
		$blacklist = DB::table('blacklists')->where('doc_id','=',$this->doc_id)->get();
		
        if($blacklist->doc_id == $this->doc_id)
        {
            return true;
        }
        return false;
    }

    public function isActive()
    {
        if($this->is_active == 1)
        {
            return true;
        }
        return false;
    }

}

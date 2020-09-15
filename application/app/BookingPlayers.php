<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPlayers extends Model
{

    protected $fillable = [
        'id', 'booking_id', 'doc_id', 'player_type', 'confirmed','confirmed_at',
        'token',
    ];

    public function booking()
    {
        return $this->hasOne('App\Booking');
    }

	public function PlayerNameGrid()
    {
			$tipo = "";
			if($this->player_type == 0)
				$tipo = " (S)";
			else
				$tipo=" (I)";
			
			return $this->UserName->first_name . " " . $this->UserName->last_name . $tipo ;
        
    }

    public function PlayerName2()
    {
			
			if($this->player_type == 0)
			{
				
				return $this->UserName->first_name . " " . $this->UserName->last_name;
			}
			else
			{
				
				return $this->GuestName->first_name . " " . $this->GuestName->last_name;
			}
		
		
			//return $this->UserName->first_name . " " . $this->UserName->last_name ;
    }


	public function PlayerNameItemRow()
	{
		$tipo = "";
		$confirmed = "";

		if($this->isUser())
			$tipo = "(S) - ";
		else
			$tipo="(I) - ";

		if($this->isConfirmed())
			$confirmed = " - Confirmado";
		else
			$confirmed = " - No Confirmado";


		return $tipo . $this->PlayerName2() . $confirmed ; 
		
		
	}
	
  

    public function PlayerName()
    {
       /* if($this->player_type == 1)
        {
            return $this->GuestName->first_name . ' ' . $this->GuestName->last_name;
        }
		else*/
		{
			

			
			
			// Retrieve all posts with at least one comment containing words like foo%
	/*		$user = App\User::whereHas('doc_id', function ($query) {
    $query->where('doc_id', '=', $this->doc_id);
})->get();
*/

/*
$users = App\User::with(['doc_id' => function ($query) {
    $query->where('doc_id', '=', $this->doc_id);
}])->get();*/


			$tipo = "";
			if($this->player_type == 0)
			{
				$tipo = " (S)";
				return $this->UserName->first_name . " " . $this->UserName->last_name . $tipo;
			}
			else
			{
				$tipo=" (I)";
				return $this->GuestName->first_name . " " . $this->GuestName->last_name . $tipo;
			}
				
			
			//return $this->UserName->first_name . " " . $this->UserName->last_name . $tipo;
	
        }
		
    }

    public function UserName()
    {
        return $this->belongsTo('App\User','doc_id','doc_id');
    }
	
    public function GuestName()
    {
        return $this->belongsTo('App\Guest','doc_id','doc_id');
    }


    public function isGuest()
    {
        if($this->player_type == 1)
        {
            return true;
        }
        return false;
    }

    public function isUser()
    {
        if($this->player_type == 0)
        {
            return true;
        }
        return false;
    }
	
	public function isConfirmed()
    {
        if($this->confirmed == 1)
        {
            return true;
        }
        return false;
    }
	
	public function isRejected()
    {
        if($this->confirmed == -1)
        {
            return true;
        }
        return false;
    }
	
	public function PlayerConfirmedStatus()
	{
		$confirmed = "";

		if($this->isConfirmed())
			$confirmed = "Confirmado";
		else if($this->isRejected())
			$confirmed = "Rechazado";
		else
			$confirmed = "No Confirmado";

		return $confirmed ; 
	}	
	
	public function PlayerRol()
	{
		$tipo = "";

		if($this->isUser())
			$tipo = "(S)";
		else
			$tipo="(I)";


		return $tipo ; 
				
	}	

}

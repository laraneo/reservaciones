<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	
	protected $primaryKey = 'id'; 
	public $incrementing = false;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'balance', 'balance_date', 'is_active', 
    ];

    // public function users()
    // {
        // return $this->hasMany('App\User', 'group_id', 'id');
    // }	

    public function group_no()
    {
        // return strtoupper ($this->id);
		$group_no =  ($this->id);
        // $group_no = substr($group_no, 0, 4) . '-' . substr($group_no, 4, 2);
        return $group_no;
    }	
	
	public function hasBalance()
    {
        if($this->balance > 0)
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

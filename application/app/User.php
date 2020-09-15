<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'phone_number', 
        'email', 
        'password', 
        'role_id', 
        'is_active', 
        'doc_id', 
        'group_id', 
        'photo_id',
        'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function isAdmin()
    {
        if($this->role->name == "Administrador")
        {
            return true;
        }
        return false;
    }

    public function isCustomer()
    {
        if($this->role->name == "Cliente")
        {
            return true;
        }
        return false;
    }
}

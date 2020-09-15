<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Faker\Provider\DateTime;

class Event extends Model
{
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'id',  
         'date', 
         'time1', 
         'time2',
         'drawtime1',
         'drawtime2',
         'description', 
         'is_active',
         'event_type',
         'category_id',
         'internal'
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function isActive()
    {
        if($this->is_active == 1)
        {
            return true;
        }
        return false;
    }

    public function getH1()
    {
      $date=date_create($this->time1);
      return date_format($date,"g:i A");
    }

    public function getH2()
    {
      $date=date_create($this->time2);
      return date_format($date,"g:i A");
    }

    public function getD1()
    {
      $date=date_create($this->drawtime1);
      return date_format($date,"g:i A");
    }

    public function getD2()
    {
      $date=date_create($this->drawtime2);
      return date_format($date,"g:i A");
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
	
	protected $primaryKey = 'doc_id'; 
	public $incrementing = false;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'doc_id',  'first_name', 'last_name', 'comments', 
    ];

}

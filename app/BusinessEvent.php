<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class BusinessEvent extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'name', 'title', 'slug', 'organizer_name', 'address', 'event_dt', ];

    public static $updatable = ['user_id' => "", 'name' => "" , 'title' => "", 'slug' => "", 'organizer_name' => "", 'address' => "", 'event_dt' => ""];

    public static $validater = array(
        'name' => 'required|max:255',
    	'title' => 'required|max:255',
    	'organizer_name' => 'required',
    	'address' => 'required',
        'event_dt' => 'required',
    	);

    public static $updateValidater = array(
    	'name' => 'required|max:255',
        'title' => 'required|max:255',
        'organizer_name' => 'required',
        'address' => 'required',
        'event_dt' => 'required',
    	);
}
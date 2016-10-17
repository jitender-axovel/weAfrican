<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmUser extends Model
{
    protected $fillable = ['user_id','fcm_reg_id'];

    protected $updatable = ['user_id' => "", 'fcm_reg_id' => ""];
	

}

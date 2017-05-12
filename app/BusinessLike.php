<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessLike extends Model
{
    protected $fillable = ['user_id', 'business_id', 'is_like', 'is_dislike'];
}

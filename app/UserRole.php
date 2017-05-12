<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name'];
    
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
=======
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
	protected $fillable = ['name'];
	
    public function user()
    {
    	return $this->hasMany('App\User');
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2

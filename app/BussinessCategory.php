<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description', 'image'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = [
        'title' => 'required|unique:bussiness_categories|max:255',
        'description' => 'required',
        'category_image' => 'required',
        ];

    public static $updateValidater = [
        'title' => 'required',
        'description' => 'required',
        ];

    public function businesses()
    {
        return $this->hasMany('App\UserBusiness');
    }
    
    public function getBusinesses()
    {
        return $this->businesses()->where('is_blocked', 0)->orderBy('sort_order', 'asc')->get();
    }

    public function apiGetCategory()
    {
        $categories = $this->where('is_blocked', 0)->get();
        return $categories;
    }
}
=======
<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessCategory extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description', 'image'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:bussiness_categories|max:255',
    	'description' => 'required',
    	'category_image' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);

    public function businesses()
    {
        return $this->hasMany('App\UserBusiness');
    }
    
    public function getBusinesses()
    {
        return $this->businesses()->where('is_blocked', 0)->orderBy('sort_order','asc')->get();
    }

    public function apiGetCategory()
    {
    	$categories = $this->where('is_blocked',0)->get();
       	return $categories;
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2

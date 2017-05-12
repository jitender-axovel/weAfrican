<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'is_show_on_mobile'];

    public function apiGetCmsPages($slug)
    {
        $cmsPages = $this->whereSlug($slug)->first();
        return $cmsPages;
    }
}
=======
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'is_show_on_mobile'];

    public function apiGetCmsPages($slug)
    {
    	$cmsPages = $this->whereSlug($slug)->first();
    	return $cmsPages;
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2

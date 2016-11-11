<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'is_show_on_mobile'];

    public function apiGetCmsPages()
    {
    	$cmsPages = $this->whereIsShowOnMobile('1')->get();
    	return $cmsPages;
    }
}

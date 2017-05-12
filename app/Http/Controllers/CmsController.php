<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CmsPage;

class CmsController extends Controller
{
    public function index($slug)
    {
        $cmsPage = CmsPage::where('slug', $slug)->first();
        $page    = $cmsPage->title;
        $flag    = 1;
        return view('cms.index', compact('cmsPage', 'page', 'flag'));
    }
}
=======
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CmsPage;

class CmsController extends Controller
{
    public function index($slug)
    {
    	$cmsPage = CmsPage::where('slug', $slug)->first();
    	$page = $cmsPage->title;
        $flag = 1;
    	return view('cms.index', compact('cmsPage', 'page' , 'flag'));
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2

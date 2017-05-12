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

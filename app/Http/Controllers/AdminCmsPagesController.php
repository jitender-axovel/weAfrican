<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CmsPage;

class AdminCmsPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cmsPages = CmsPage::get();
        $page = 'We African - Admin';

        return view('admin.cms.index', compact('cmsPages', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cmsPage = CmsPage::find($id);
        $page = 'We African - Edit ' . $cmsPage->title;

        return view('admin.cms.edit', compact('cmsPage', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $cmsPage = CmsPage::find($id);

        if(!$cmsPage) {
            return back()->with('error', "Sorry, could not update page's content.");
        }

        $cmsPage->content = $input['content'];

        if($cmsPage->save()) {
            return redirect('admin/cms')->with('success', $cmsPage->title . ' updated successfully.');
        } else {
            return back()->with('error', $cmsPage->title . ' could not be updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

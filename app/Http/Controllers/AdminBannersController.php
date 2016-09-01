<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banner;
use Validator;

class AdminBannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Banners- Admin';
        $banners = Banner::get();
        return view('admin.banners.index', compact('page', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Banner - Admin";
        return view('admin.banners.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->input(), Banner::$validater 
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return json_encode($validator->errors()->all());
            } 
        }

        $input = $request->input();
  
            $input = array_intersect_key($input,Banner::$updatable);
            $banner = new Banner();
            $banner->name = $input['name'];
            $banner->city_id = $input['city_id'];
            $banner->save();

            if($request->ajax()) {
                return json_encode(['status' => 'success','url' => url('admin/banner')]);
            } else {
                return back();
            }
            
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
        $page = "Edit Banner - Admin";
        $banner = Banner::find($id);
        return view('admin.banners.edit',compact('banner','page'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',    
        ]);

        if ($validator->fails()) {
            return redirect('admin/banner'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = $request->input();

        
            $input = array_intersect_key($input, Banner::$updatable);
            $banners = Banner::where('id',$id)->update($input);
        
            if($banners > 0 ){
                
                return redirect('admin/banner')->with('success', 'Banner Updated successfully');
            } else {

                return back()->with('error', 'Banner could not be updated. Please try again.');
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
        $banner = Banner::findOrFail($id);
        if($banner->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' Banner Plan deleted  successfully',
            );
             return json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' Banner
                Plan can not be deleted.Please try again',
            );
             return json_encode($response);

        }
    }

    public function isActivated($id)
    {
        $banner=Banner::find($id);
       
        if($banner->is_activated == 0){ 
            $banner=Banner::where('id', $id)->update(['is_activated' => '1']);
            return redirect('admin/banner')->with('success', 'Banner activated successfully');

        } else if($banner->is_activated == 1){ 
           $banner=Banner::where('id', $id)->update(['is_activated' => '0']);
            return redirect('admin/banner')->with('success', ' Banner deactivated successfully');
        }   
    }
}

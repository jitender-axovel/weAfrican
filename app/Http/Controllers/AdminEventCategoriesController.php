<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\EventCategory;
use App\Helper;
use Validator;

class AdminEventCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Event Categories';
        $categories = EventCategory::get();
        return view('admin.event-categories.index', compact('pageTitle', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Event Category";
        return view('admin.event-categories.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), EventCategory::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($request->file('image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName=$request->file('image')->move(config('image.category_image_path'), $image);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
        } else {
            return back()->with('Error', 'Category image is not uploaded. Please try again');
        }

        $input = $request->input();
        try{
            $category = new EventCategory();

            $category->title = $input['title'];
            $category->description = $input['description'];
            $category->image = $image;
            $category->slug = Helper::slug($input['title'], $category->id);

            $category->save();
            return redirect('admin/category/event/')->with('success', 'New Bussiness category created successfully');
        }catch(Exception $e){
            return back()->with('error', 'There is some error. Please try after some time');
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
        $pageTitle = "Admin - Edit Event Category";
        $category = EventCategory::find($id);
        return view('admin.event-categories.edit',compact('pageTitle','category'));
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
        
        $validator = Validator::make($request->all(), EventCategory::$updateValidater);

        if ($validator->fails()) {
            return redirect('admin/category/event/'.$id.'/edit')->withErrors($validator)->withInput();
        }

         if ($request->hasFile('image') ){
        if ($request->file('image') && $request->file('image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName = $request->file('image')->move(config('image.category_image_path'),$image );
            
           $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
            
        } else {
            return redirect('admin/category/event')->with('Error', 'Event Category image is not uploaded.Please try again');
        }
    }

        $input = $request->input();

        try
        {

            $event = array_intersect_key($input, EventCategory::$updatable);
           
           
            if(isset($fileName)) {
               $event['image'] =  $file.'.'.$ext;
                 
                $event = EventCategory::where('id',$id)->update($event);
            } else {
                $event = EventCategory::where('id',$id)->update($event);
            }

            return redirect('admin/category/event')->with('success', ' Business Category updated successfully');
        }catch(Exception $e){
            return back()->with('error', 'There is some error. Please try after some time');
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
        $category = EventCategory::findOrFail($id);

        if($category->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Event Category deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Event Category can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
    
    public function block($id)
    {
        $category = EventCategory::find($id);
        $category->is_blocked = !$category->is_blocked;
        $category->save();

        if ($category->is_blocked) {
            return redirect('admin/category/event')->with('success', 'Event Category has been blocked successfully');
        } else {
            return redirect('admin/category/event')->with('success', 'Event Category has been unblocked');
        }
    }
}
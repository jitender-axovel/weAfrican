<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\BussinessCategory;
use App\Helper;
use Validator;

class AdminBussinessCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Business Categories';
        $categories = BussinessCategory::get();
        return view('admin.categories.index', compact('pageTitle', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Business Category";
        return view('admin.categories.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BussinessCategory::$validater );

        if ($validator->fails()) {
            return redirect('admin/bussiness/category/create')->withErrors($validator)->withInput();
        }

        if($request->file('category_image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('category_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName=$request->file('category_image')->move(config('image.category_image_path'), $image);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
        } else {
            return redirect('admin/bussiness/category/create')->with('Error', 'Category image is not uploaded. Please try again');
        }

        $input = $request->input();

        if($input['title'] == $input['confirm_title']) {
            $category = new BussinessCategory();

            $category->title = $input['title'];
            $category->description = $input['description'];
            $category->image = $image;
            $category->slug = Helper::slug($input['title'], $category->id);

            $category->save();

            return redirect('admin/bussiness/category')->with('success', 'New Bussiness category created successfully');
        } else {
            return redirect('admin/bussiness/category/create')->with('error', 'Title and confirm title should be same');
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
        $pageTitle = "Admin - Edit Bussiness Category";
        $category = BussinessCategory::find($id);
        return view('admin.categories.edit',compact('pageTitle','category'));
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
        $validator = Validator::make($request->all(),BussinessCategory::$updateValidater);

        if ($validator->fails()) {
            return redirect('admin/bussiness/category/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if ($request->hasFile('category_image') ){
        if ($request->file('category_image') && $request->file('category_image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('category_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName = $request->file('category_image')->move(config('image.category_image_path'),$image );
            
           $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.category_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.category_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
            
        } else {
            return redirect('admin/bussiness/category')->with('Error', 'Business Category image is not uploaded.Please try again');
        }
}
        $input = $request->input();

        if($input['title'] == $input['confirm_title'])
        {
            $category = array_intersect_key($input, BussinessCategory::$updatable);
           
           
            if(isset($fileName)) {
               $category['image'] =  $file.'.'.$ext;
                 
                $category = BussinessCategory::where('id',$id)->update($category);
            } else {
                $category = BussinessCategory::where('id',$id)->update($category);
            }

            return redirect('admin/bussiness/category')->with('success', ' Business Category updated successfully');
        } else {
            return back()->with('error', 'Title and confirm title should be same');
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
        $category = BussinessCategory::findOrFail($id);

        if($category->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business Category deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Category can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $category = BussinessCategory::find($id);
        $category->is_blocked = !$category->is_blocked;
        $category->save();

        if ($category->is_blocked) {
            return redirect('admin/bussiness/category')->with('success', 'Bussiness Category has been blocked successfully');
        } else {
            return redirect('admin/bussiness/category')->with('success', 'Bussiness Category has been unblocked');
        }
    }
}
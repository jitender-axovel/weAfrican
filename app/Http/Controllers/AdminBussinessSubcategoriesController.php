<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\BussinessSubcategory;
use App\BussinessCategory;
use App\Helper;
use Validator;


class AdminBussinessSubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Business Sub-categories';
        $categories = BussinessSubcategory::get();
        return view('admin.sub-categories.index', compact('pageTitle', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Business Sub-Category";
        $categories = BussinessCategory::where('is_blocked',0)->get();
        return view('admin.sub-categories.create', compact('pageTitle', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BussinessSubcategory::$validater );
        if ($validator->fails()) {
            return redirect('admin/bussiness/sub-category/create')->withErrors($validator)->withInput();
        }

        if($request->file('category_image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('category_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName=$request->file('category_image')->move(config('image.subcategory_image_path'), $image);

            $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
        } else {
            return redirect('admin/bussiness/category/create')->with('Error', 'Category image is not uploaded. Please try again');
        }

        $input = $request->input();

        if($input['title'] == $input['confirm_title']) {
            $subcategory = new BussinessSubcategory();
            $subcategory->category_id = $input['category_id'];
            $subcategory->title = $input['title'];
            $subcategory->description = $input['description'];
            $subcategory->image = $image;
            $subcategory->slug = Helper::slug($input['title'], $subcategory->id);

            $subcategory->save();

            return redirect('admin/bussiness/sub-category')->with('success', 'New Bussiness Sub-Category created successfully');
        } else {
            return redirect('admin/bussiness/sub-category/create')->with('error', 'Title and confirm title should be same');
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
        $pageTitle = "Admin - Edit Bussiness Sub-Category";
        $subcategory = BussinessSubcategory::find($id);
        $categories = BussinessCategory::where('is_blocked',0)->get();
        return view('admin.sub-categories.edit',compact('pageTitle','subcategory','categories'));
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
        $validator = Validator::make($request->all(),BussinessSubcategory::$updateValidater);

        if ($validator->fails()) {
            return redirect('admin/bussiness/sub-category/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if ($request->hasFile('category_image') ){
            if ($request->file('category_image') && $request->file('category_image')->isValid()) {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('category_image')->getClientOriginalExtension();
                $image = $file.'.'.$ext;
                $fileName = $request->file('category_image')->move(config('image.subcategory_image_path'),$image );
                
               $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.subcategory_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.subcategory_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
                
            } else {
                return redirect('admin/bussiness/sub-category')->with('Error', 'Business Category image is not uploaded.Please try again');
            }
        }
        $input = $request->input();

        if($input['title'] == $input['confirm_title'])
        {
            $subcategory = array_intersect_key($input, BussinessSubcategory::$updatable);
           
           
            if(isset($fileName)) {
               $subcategory['image'] =  $file.'.'.$ext;
                 
                $subcategory = BussinessSubcategory::where('id',$id)->update($subcategory);
            } else {
                $subcategory = BussinessSubcategory::where('id',$id)->update($subcategory);
            }

            return redirect('admin/bussiness/sub-category')->with('success', ' Business Sub-Category updated successfully');
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
        $category = BussinessSubcategory::findOrFail($id);

        if($category->forceDelete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business Sub-Category deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Sub-Category can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $subcategory = BussinessSubcategory::find($id);
        $subcategory->is_blocked = !$subcategory->is_blocked;
        $subcategory->save();

        if ($subcategory->is_blocked) {
            return redirect('admin/bussiness/sub-category')->with('success', 'Bussiness Sub-Category has been blocked successfully');
        } else {
            return redirect('admin/bussiness/sub-category')->with('success', 'Bussiness Sub-Category has been unblocked');
        }
    }
}

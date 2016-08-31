<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

use App\Category;
use App\Helper;
use Validator;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Category - Admin';
        $categories = Category::get();
        return view('admin.categories.index', compact('page', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Category - Admin";
        return view('admin.categories.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->input(), Category::$validater 
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return json_encode($validator->errors()->all());
            } 
        }

        $input = $request->input();

        if($input['title'] == $input['confirm_title']) {
           
            $input['slug'] = Helper::slug($input['title']);
            $input = array_intersect_key($input,Category::$updatable);
            // $category = Category::create($input); dd($category);
            $category = new Category();
            $category->title = $input['title'];
            $category->slug = $input['slug'];
            $category->save();

            if($request->ajax()) {
                return json_encode(['status' => 'success','url' => url('admin/category')]);
            } else {
                return back();
            }
            
        } else {

            return json_encode(['status' => 'error','response' => 'Title and confirm title should be same.']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' Category deleted  successfully',
            );
             return json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' Category can not be deleted.Please try again',
            );
             return json_encode($response);

        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Http\Requests;
use App\BusinessProduct;
use App\UserBusiness;
use App\BusinessNotification;
use App\Helper;
use Auth;
use Validator;

class BusinessProductsController extends Controller
{
    /**
     * Author:Divya
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->businessNotification = new BusinessNotification();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Products";
        $products = BusinessProduct::where('user_id',Auth::id())->where('is_blocked',0)->paginate(10);
        return view('business-product.index', compact('products','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Business Product -create";
        return view('business-product.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BusinessProduct::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($request->file('product_image')->isValid()) {
            $file = md5(uniqid(rand(), true));
            $ext = $request->file('product_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName=$request->file('product_image')->move(config('image.product_image_path'), $image);

            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
        } else {
            return back()->with('Error', 'Category image is not uploaded. Please try again');
        }

        $input = $request->input();

        $business = UserBusiness::whereUserId(Auth::id())->first();

        $product = new BusinessProduct();

        $product->user_id = Auth::id();
        $product->business_id = $business->id;
        $product->title = $input['title'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->image = $image;
        $product->slug = Helper::slug($input['title'], $product->id);

        $product->save();

        $source = 'product';
        $this->businessNotification->saveNotification($business->id, $source);

        return redirect('business-product')->with('success', 'New Product created successfully');
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
        $pageTitle = "Business Product-Edit";
        $product = BusinessProduct::find($id);
        return view('business-product.edit',compact('pageTitle','product'));
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
        $validator = Validator::make($request->all(),BusinessProduct::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->file('product_image')) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('product_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $fileName = $request->file('product_image')->move(config('image.product_image_path'),$image );
            
            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$image;
            shell_exec($command);

            $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$image;
            shell_exec($command);
        }

        $input = $request->input();

        $input = array_intersect_key($input, BusinessProduct::$updatable);

        if(isset($fileName)) {
            $input['image'] =  $file.'.'.$ext;
            $product = BusinessProduct::where('id',$id)->update($input);
        } else {
            $product = BusinessProduct::where('id',$id)->update($input);
        }

            return redirect('business-product')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = BusinessProduct::findOrFail($id);

        if($product->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Product deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Product can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}
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
        $image = "";
        if ($request->hasFile('product_image')) {
            $files = $request->file('product_image');
            foreach($files as $file){
                if($file->isValid())
                {
                    $file2 = md5(uniqid(rand(), true));
                    $extension = $file->getClientOriginalExtension();
                    $img_name = $file2.'.'.$extension;
                    $image .= $file2.'.'.$extension.'|';
                    $fileName=$file->move(config('image.product_image_path'), $img_name);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$img_name;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$img_name;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$img_name;
                    shell_exec($command);
                }else
                {
                    return back()->with('Error', 'Product image is not uploaded. Please try again');
                }
            }
        }else
        {
            return back()->with('Error', 'Product image is not uploaded. Please try again');
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
        $pageTitle = "Business Product-View";
        $product = BusinessProduct::find($id);
        return view('business-product.view',compact('pageTitle','product'));
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

        $product = BusinessProduct::where('id',$id)->get();
        $img = explode('|',($product[0]->image));
        if ($request->hasFile('product_image')) {
            $files = $request->file('product_image');
            $i=0;
            foreach($files as $file){
                if($file->isValid())
                {
                    $file2 = md5(uniqid(rand(), true));
                    $extension = $file->getClientOriginalExtension();
                    $img_name = $file2.'.'.$extension;
                    $img[$i] = $file2.'.'.$extension;
                    $fileName=$file->move(config('image.product_image_path'), $img_name);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$img_name;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$img_name;
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$img_name.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$img_name;
                    shell_exec($command);
                }else
                {
                    return back()->with('Error', 'Product image is not uploaded. Please try again');
                }
                $i++;
            }
        }

        $input = $request->input();

        $input = array_intersect_key($input, BusinessProduct::$updatable);
        $input['image'] =  implode("|",$img);
        $product = BusinessProduct::where('id',$id)->update($input);
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
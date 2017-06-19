<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Http\Requests;
use App\BusinessProduct;
use App\UserBusiness;
use App\BusinessNotification;
use App\BusinessProductImage;
use App\Helper;
use Auth;
use Validator;
use Image;

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
        $input = $request->input();
        $validator = Validator::make($request->all(), BusinessProduct::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $business = UserBusiness::whereUserId(Auth::id())->first();

        $product = new BusinessProduct();

        $product->user_id = Auth::id();
        $product->business_id = $business->id;
        $product->title = $input['title'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->slug = Helper::slug($input['title'], $product->id);

        $product->save();

        $business_product_image['user_id'] = Auth::id();
        $business_product_image['business_id'] = $business->id;
        $business_product_image['business_product_id'] = $product->id;

        if ($request->hasFile('product_image')) {
            $files = $request->file('product_image');
            foreach ($files as $key => $file) {
                if($file->isValid())
                {
                    $business_product_image['image'] = $file;
                    $business_product_image['featured_image'] = 0;

                    $validator = Validator::make($business_product_image, BusinessProductImage::$validater);
                    
                    if ($validator->fails()) {
                        return back()->withErrors($validator)->withInput();
                    }
                    
                    $file2 = md5(uniqid(rand(), true));
                    $extension = $file->getClientOriginalExtension();
                    $img_name = $file2.'.'.$extension;
                    
                    $img = Image::make($file->getRealPath());
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                    
                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                    
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                    
                    $fileName = $file->move(config('image.product_image_path'), $img_name);
                    $business_product_image['image'] = $img_name;
                    
                    if($input['featured_image']-1==$key)
                    {
                        $business_product_image['featured_image'] = 1;
                    }

                    $product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                    $product_image = BusinessProductImage::create($product_image);
                    $product_image->save();

                }else
                {
                    return back()->with('Error', 'Product image is not uploaded. Please try again');
                }
            }
        }else
        {
            return back()->with('Error', 'Product image is not uploaded. Please try again');
        }

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
        $product_images = BusinessProductImage::where('user_id',$product->user_id)->where('business_id',$product->business_id)->where('business_product_id',$product->id)->orderBy('id', 'ASC')->get();
        return view('business-product.edit',compact('pageTitle','product','product_images'));
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
        BusinessProduct::$updateValidater['featured_image'] = 'required';
        $validator = Validator::make($request->all(),BusinessProduct::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = array_intersect_key($input, BusinessProduct::$updatable);

        $product = BusinessProduct::where('id',$id)->update($product);

        $product = BusinessProduct::where('id',$id)->first();

        $list = BusinessProductImage::where('business_product_id',$id)->pluck('id')->toArray();
        if(count($list)>0){
            foreach (array_intersect($list, $input['product_image_id']) as $key => $value) {
                $product_image = BusinessProductImage::whereId($value)->first();
                $old_image = $product_image->image;
                $product_image->featured_image = 0;

                if($request->hasFile('product_image'))
                {
                    $files = $request->file('product_image');
                    if(isset($files[$value]))
                    {
                        if($files[$value]->isValid())
                        {
                            $file2 = md5(uniqid(rand(), true));
                            $extension = $files[$value]->getClientOriginalExtension();
                            $img_name = $file2.'.'.$extension;
                            
                            $img = Image::make($files[$value]->getRealPath());
                            
                            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.product_image_path'), $img_name);
                            $this->deleteImage(config('image.product_image_path'),$old_image);
                            $product_image->image = $img_name;
                            
                        }else
                        {
                            return back()->with('Error', 'Product image is not uploaded. Please try again');
                        }
                    }
                }
                $product_image->save();
            }
            foreach (array_diff($list,$input['product_image_id']) as $value) {
                $product_image = BusinessProductImage::whereId($value)->first();
                $this->deleteImage(config('image.product_image_path'),$product_image->image);
                BusinessProductImage::whereId($value)->delete();
            }
        }
        if(count($request->file('product_image'))>0){
            foreach (array_keys($request->file('product_image')) as $value) {
                $business_product_image['user_id'] = $product->user_id;
                $business_product_image['business_id'] = $product->business_id;
                $business_product_image['business_product_id'] = $product->id;
                $business_product_image['featured_image'] = 0;
                if($request->hasFile('product_image'))
                {
                    $files = $request->file('product_image');
                    if(isset($files[$value]))
                    {
                        if($files[$value]->isValid())
                        {
                            $file2 = md5(uniqid(rand(), true));
                            $extension = $files[$value]->getClientOriginalExtension();
                            $img_name = $file2.'.'.$extension;

                            $img = Image::make($files[$value]->getRealPath());
                        
                            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.product_image_path'), $img_name);
                            $business_product_image['image'] = $img_name;

                            $product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                            $product_image = BusinessProductImage::create($product_image);
                            $product_image->save();
                        }else
                        {
                            return back()->with('Error', 'Product image is not uploaded. Please try again');
                        }
                    }
                }
            }
        }
        $product_image = BusinessProductImage::whereId(BusinessProductImage::offset($request->input('featured_image')-1)->limit(1)->where('business_product_id',$id)->pluck('id')->first())->update(array('featured_image'=>1));
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

        $product_images = BusinessProductImage::where('business_product_id',$id)->get();

        if(count($product_images)>0)
        {
            foreach ($product_images as $product_image) {
                $this->deleteImage(config('image.product_image_path'),$product_image->image);
            }
        }

        if($product->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Product deleted successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Product can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    /**
     * Remove the specified image and thumbnails from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($image_path,$file_name)
    {
        if($file_name!=""){
            unlink($image_path.$file_name);
            unlink($image_path.'thumbnails/small/'.$file_name);
            unlink($image_path.'thumbnails/medium/'.$file_name);
            unlink($image_path.'thumbnails/large/'.$file_name);
        }
    }

}
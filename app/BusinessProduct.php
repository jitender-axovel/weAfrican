<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Validator;

class BusinessProduct extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'business_id', 'title', 'slug', 'description', 'price', 'image'];

    public static $updatable = ['id' => "", 'business_id' => "", 'user_id' => "", 'title' => "", 'slug' => "", 'description' => "", 'price' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:business_products|max:255',
    	'description' => 'required',
        'price' => 'required|integer',
        'product_image.0' => 'required|image|mimes:jpg,png,jpeg',
        'product_image.*' => 'image|mimes:jpg,png,jpeg',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
        'price' => 'required|integer',
        'product_image.0' => 'required|image|mimes:jpg,png,jpeg',
        'product_image.*' => 'image|mimes:jpg,png,jpeg',
    	);

    public function product_business()
    {
        return $this->hasOne('App\UserBusiness','user_id');
    }

    public function apiGetUserBusinessProducts($input)
    {
        $products = $this->where('user_id',$input['userId'])->where('is_blocked',0)->get();
        return $products;
    }

    public function apiPostUserProduct(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if(isset($input['productId'])){

            if(isset($input['productImage']) && !empty($input['productImage']))
            {
                $data = $input['productImage'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.product_image_path').$image;

                $success = file_put_contents($file, $data);
                    
                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
            }

            $product = array_intersect_key($input, BusinessProduct::$updatable);

            $product['user_id'] = $input['userId'];
            $product['id'] = $input['productId'];

            if(isset($image)) {
                $product['image'] =  $image;
                $product = BusinessProduct::where('id', $input['productId'])->where('user_id', $input['userId'])->update($product);
            } else {
                $product = BusinessProduct::where('id', $input['productId'])->where('user_id', $input['userId'])->update($product);
            }

            if($product)
                return response()->json(['status' => 'success','response' => "Product updated successfully."]);
            else
                return response()->json(['status' => 'failure','response' => "Product could not updated successfully.Please try again."]);
        }else{
             
            if(isset($input['productImage']) && !empty($input['productImage']))
            {
                $data = $input['productImage'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.product_image_path').$image;

                $success = file_put_contents($file, $data);
                    
                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
            }


            $product = array_intersect_key($request->input(), BusinessProduct::$updatable);
            $product['user_id'] = $input['userId'];
            $product['business_id'] = $input['businessId'];

            if(isset($image)){
                $product['image'] = $image;
            }

            $product = BusinessProduct::create($product);
            $product->save();

            $product->slug = Helper::slug($product->title, $product->id);

            if($product->save()){
                return response()->json(['status' => 'success','response' => $product]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Product could not be created .Please try later.']);
            }
        }
    }
}
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
        'product_image' => 'required|image|mimes:jpg,png,jpeg',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
        'price' => 'required|integer',
        'product_image' => 'image|mimes:jpg,png,jpeg',
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
        if($input == NULL)
        {
            return json_encode(['status' =>'error','response'=> 'Input parameters are missing']); 
        }

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'productImage' => 'image|mimes:jpg,png,jpeg',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if(isset($input['productId'])){

            if ($request->hasFile('productImage') ){
                if ($request->file('productImage')) {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('productImage')->getClientOriginalExtension();
                    $image = $file.'.'.$ext;
                    $fileName = $request->file('productImage')->move(config('image.product_image_path'),$image );
                    
                    $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.product_small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);
                }
            }
            $input['user_id'] = $input['userId'];
            $input['id'] = $input['productId'];
            
            $product = array_intersect_key($input, BusinessProduct::$updatable);
           
            if(isset($fileName)) {
                $input['image'] =  $file.'.'.$ext;
                $product = BusinessProduct::where('id', $input['id'])->where('user_id', $input['user_id'])->update($product);
            } else {
                $product = BusinessProduct::where('id', $input['id'])->where('user_id', $input['user_id'])->update($product);
            }

            return response()->json(['status' => 'success','response' => "Product updated successfully."]);
        }else{
             if(isset($input['productImage'])){
                $data = "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";
                $data = base64_decode($data); 
                $im = imagecreatefromstring($data); 

                if ($im !== false) {
                    $file = md5(uniqid(rand(), true));
                    $image = $file.'.'.'png';
                    imagepng($im, config('image.product_image_path').$image) ; 
                    imagedestroy($im); 
                } else { 
                    dd('An error occurred.'); 
                }
            }

            /*if ($request->hasFile('productImage') ){
                if($request->file('productImage')->isValid()) {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('productImage')->getClientOriginalExtension();
                    $image = $file.'.'.$ext;
                    $fileName=$request->file('productImage')->move(config('image.product_image_path'), $image);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.product_small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);
                }
            } */

            $product = array_intersect_key($request->input(), BusinessProduct::$updatable);
            $product['user_id'] = $input['userId'];
            $product['business_id'] = $input['businessId'];

            if(isset($fileName)){
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
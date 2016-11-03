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

        if(isset($input['productId'])){

            $validator = Validator::make($input, [
                'title' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|integer',
                'productImage' => 'image|mimes:jpg,png,jpeg',
                ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }

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
              $validator = Validator::make($input, [
                'title' => 'required|unique:business_products|max:255',
                'description' => 'required',
                'price' => 'required|integer',
                'productImage' => 'image|mimes:jpg,png,jpeg',
                ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }
            if ($request->hasFile('productImage') ){
                if($request->file('productImage')->isValid()) {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('productImage')->getClientOriginalExtension();
                    $image = $file.'.'.$ext;
                    $fileName=$request->file('productImage')->move(config('image.product_image_path'), $image);

                    $command = 'ffmpeg -i '.config('image.product_image_path').$image.' -vf scale='.config('image.product_small_thumbnail_width').':-1 '.config('image.product_image_path').'thumbnails/small/'.$image;
                    shell_exec($command);
                }
            } 

            $product = array_intersect_key($request->input(), BusinessProduct::$updatable);
            $product['user_id'] = $input['userId'];

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
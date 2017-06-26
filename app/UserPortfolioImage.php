<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\UserBusiness;
use Validator;
use Image;
use File;

class UserPortfolioImage extends Model
{
    protected $fillable = ['user_id', 'business_id', 'user_portfolio_id', 'title', 'description', 'image', 'featured_image'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'user_portfolio_id' => "", 'title' => "", 'description' => "", 'image' => "", 'featured_image' => ""];
    
    public static $validater = array(
    	'title' => 'required|unique:user_portfolio_images|max:255',
    	'description' => 'required',
        'image' => 'required|image|mimes:jpg,png,jpeg',
    	);

    public function apiGetUserPortfolioImages($input)
    {
        $portfolioImages = $this->whereuserPortfolioId($input['portfolioId'])->wherebusinessId($input['businessId'])->whereuserId($input['userId'])->get();
        return $portfolioImages;
    }

    public function apiPostUserPortfolioDetail(Request $request)
    {
    	$input = $request->input();

    	$rule = array(
    		'userId' => 'required',
            'businessId' => 'required',
            'portfolioId' => 'required',
    		'title' => 'required',
            'description' => 'required',
            'featured_image' => 'integer'
    	);

    	if(isset($input['portfolioImageId']))
    	{
    		$rule['image'] = 'string';
    	}else
    	{
    		$rule['image'] = 'required|string';
    	}
    	
        $validator = Validator::make($input, $rule);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input['user_id'] = $input['userId'];
    	$input['business_id'] = $input['businessId'];
    	$input['user_portfolio_id'] = $input['portfolioId'];

        if(isset($input['portfolioImageId']))
        {
        	$portfolioImage = $this->whereuserId($input['user_id'])->wherebusinessId($input['business_id'])->whereuserPortfolioId($input['user_portfolio_id'])->whereId($input['portfolioImageId'])->first();
        	if($portfolioImage)
        	{
        		if(isset($input['image']) && !empty($input['image']))
	        	{
	        		$data = $input['image'];

	                $img = str_replace('data:image/jpeg;base64,', '', $data);
	                $img = str_replace(' ', '+', $img);

	                $data = base64_decode($img);

	                $fileName = md5(uniqid(rand(), true));

	                $image = $fileName.'.'.'png';

	                $file = config('image.portfolio_image_path').$image;

	                $success = file_put_contents($file, $data);

	                $img = Image::make($file);
	                    
	                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
	                             $constraint->aspectRatio();
	                        })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$image); 

	                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
	                     $constraint->aspectRatio();
	                })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$image);
	                        
	                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
	                     $constraint->aspectRatio();
	                })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$image);
	        	}

	        	if($portfolioImage->image!="")
	        	{
	        		if(File::exists(config('image.portfolio_image_path').$portfolioImage->image))
	        		{
	        			File::delete(config('image.portfolio_image_path').$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/small/'.$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/medium/'.$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/large/'.$portfolioImage->image);
	        		}
	        	}

	        	if(isset($image))
	        	{
	        		$input['image'] = $image;
	        	}

	        	$portfolioImage = array_intersect_key($input, UserPortfolioImage::$updatable);

	        	$portfolioImage = $this->whereuserId($input['user_id'])->wherebusinessId($input['business_id'])->whereuserPortfolioId($input['user_portfolio_id'])->whereId($input['portfolioImageId'])->update($portfolioImage);

	        	if($portfolioImage)
	                return response()->json(['status' => 'success','response' => "Portfolio Image has been updated successfully."]);
	            else
	                return response()->json(['status' => 'failure','response' => "Portfolio Image could not updated successfully.Please try again."]);

        	}else
        	{
        		return response()->json(['status' => 'exception','response' => 'portfolio Image dose not exists']);
        	}
        	
        }else
        {
        	if(isset($input['image']) && !empty($input['image']))
        	{
        		$data = $input['image'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.portfolio_image_path').$image;

                $success = file_put_contents($file, $data);

                $img = Image::make($file);
                    
                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$image); 

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$image);
                        
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$image);
        	}

            if(isset($image)){
                $input['image'] = $image;
            }

            $portfolioImage = array_intersect_key($input, UserPortfolioImage::$updatable);

            $portfolioImage = UserPortfolioImage::create($portfolioImage);

            if($portfolioImage->save()){
                return response()->json(['status' => 'success','response' => $portfolioImage]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Portfolio Image could not be added .Please try later.']);
            }
        }
    }

    public function apiRemoveUserPortfolioImages($input)
    {

        $rule = array(
            'user_id' => 'required',
            'business_id' => 'required',
            'user_portfolio_id' => 'required',
            'id' => 'required',
        );

        $validator = Validator::make($input, $rule);
        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $portfolioImage = $this->where(function($q) use ($input){
            foreach($input as $key => $value){
                $q->where($key, '=', $value);
            }})
        ->first();
        if($portfolioImage)
        {
            if($portfolioImage->image!="")
            {
                if(File::exists(config('image.portfolio_image_path').$portfolioImage->image))
                {
                    File::delete(config('image.portfolio_image_path').$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/small/'.$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/medium/'.$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/large/'.$portfolioImage->image);
                }
            }
            if($this->find($portfolioImage->id)->forceDelete())
            {
                $portfolioImages = $this->whereuserPortfolioId($input['user_portfolio_id'])->wherebusinessId($input['business_id'])->whereuserId($input['user_id'])->get();
                return response()->json(['status' => 'success','response' => $portfolioImages]);
            }else
            {
                return response()->json(['status' => 'failure','response' => 'System Error:Portfolio Image could not be deleted .Please try later.']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'User Portfolio Image dos\'nt exists']);
        }
    }
}

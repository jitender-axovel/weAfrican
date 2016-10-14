<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Validator;

class BusinessService extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'title', 'slug', 'description'];

    public static $updatable = ['user_id' => "", 'title' => "", 'slug' => "", 'description' => ""];

    public static $validater = array(
    	'title' => 'required|unique:business_services|max:255',
    	'description' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);

    public function apiGetBusinessServices($input)
    {
        $services = $this->where('user_id',$input['userId'])->where('is_blocked',0)->get();
        return $services;
    }

    public function apiPostUserService(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' =>'exception','response'=> 'Input parameters are missing']); 
        }

        if(isset($input['serviceId']))
        {   
            $validator = Validator::make($input, [
            'title' => 'required|max:255',
            'description' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }

            $input['user_id'] = $input['userId'];
            $input['id'] = $input['serviceId'];
            
            $service = array_intersect_key($input, BusinessService::$updatable);
           
            $service = BusinessService::where('id', $input['id'])->where('user_id', $input['user_id'])->update($service);
          
            return response()->json(['status' => 'success','response' => "Service updated successfully."]);

        }else{

            $validator = Validator::make($input, [
                'title' => 'required|unique:business_services|max:255',
                'description' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->all()]);   
            }

            $service = array_intersect_key($request->input(), BusinessService::$updatable);
            $service['user_id'] = $input['userId'];

            $service = BusinessService::create($service);
            $service->save();

            $service->slug = Helper::slug($service->title, $service->id);

            if($service->save()){
                return response()->json(['status' => 'success','response' => $service]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Service could not be created .Please try later.']);
            }
        }
    }
}
<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\BussinessCategory;
use App\UserBusiness;
use Auth;
use Validator;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Users';
        $users = User::whereIn('user_role_id',array(3,4))->get();
        return view('admin.users.index', compact('pageTitle', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'keywords' =>'required',
            'email' => 'required|email|max:255|unique:user_businesses',
            'pin_code' => 'regex:/\b\d{6}\b/|required|numeric',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'business_logo' => 'image|mimes:jpg,png,jpeg,gif',
            'secondary_phone_number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $input = $request->input();
        
        if ($request->hasFile('business_logo') ){
            if ($request->file('business_logo')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('business_logo')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 

                $fileName = $request->file('business_logo')->move(config('image.logo_image_path'), $image);

                $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.logo_small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                shell_exec($command);
            }
        }

        User::where('id',$input['id'])->update(['user_role_id' => 3]);
        $user = User::where('id', $input['id'])->first();
    
        $business = array_intersect_key($input, UserBusiness::$updatable);

        $business['business_id']=substr($user->full_name,0,3).rand(0,999);
        $business['user_id'] = $user->id;
        $business['is_agree_to_terms'] = 1;

        if(isset($fileName)){
            $business['business_logo'] = $image;
        }

        $business = UserBusiness::create($business);
        $business->save();

        if($business)
        {
            return redirect('admin/users')->with('success', 'User Business created successfully.'); 
               
        } else {
            return back()->with('error', 'User business could not be created.Please try again');
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
        $pageTitle = "Admin - Add Bussiness user";
        $user = User::find($id);

        $categories = BussinessCategory::where('is_blocked', 0)->get();
        return view('admin.users.create', compact('pageTitle', 'categories', 'user'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Admin - Edit User';
        $user = User::find($id);
        return view('admin.users.edit', compact('pageTitle', 'user'));
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
        $user = User::find($id);

        $input = array_intersect_key($request->input(), User::$updatable);

        if ($user->update($input)) {
            return redirect('admin/users')->with('success', 'Information has been updated.');
        } else {
            return redirect('admin/users')->with('error', 'Information has not been updated.');
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
        $user = User::findOrFail($id);
        if($user->forceDelete()){
            $response = array(
                'status' => 'success',
                'message' => ' User deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' User can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
       
        if($user->is_blocked){ 
            return redirect('admin/users')->with('success', 'User blocked successfully');
        } else { 
            return redirect('admin/users')->with('success', 'User unblocked successfully');
        }   
    }

    public function getSearch(Request $request=null)
    {
        $input = $request->input();
        $condition = array();
        if($input['country']!="")
        {
            $condition['country'] = $input['country'];
        }
        if($input['state']!="")
        {
            $condition['state'] = $input['state'];
        }
        if($input['city']!="")
        {
            $condition['city'] = $input['city'];
        }
        if(isset($input['category']) && $input['category']!="")
        {
            $condition['bussiness_category_id'] = $input['category'];
        }
        /*if(isset($input['subcategory']) && $input['subcategory']!="")
        {
            $condition['bussiness_subcategory_id'] = $input['subcategory'];
        }*/
        if($input['page']=='user')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $userBusiness = UserBusiness::where($condition)->pluck('user_id');
                $users = User::whereIn('id',$userBusiness)->get();
            }else
            {
                $users = User::whereIn('user_role_id',array(3,4))->get();
            }
            $pageTitle = 'Admin - Users';
            return view('admin.users.index', compact('pageTitle', 'users'));
        }else
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $businesses = UserBusiness::where($condition)->get();
            }else
            {
                $businesses = UserBusiness::get();
            }
            $pageTitle = 'Admin - User Business';
            return view('admin.business.index', compact('pageTitle', 'businesses'));
        }
    }

    public function exportToCsv(Request $request)
    {
        $input = $request->input();
        $condition = array();
        if($input['country']!="")
        {
            $condition['user_businesses.country'] = $input['country'];
        }
        if($input['state']!="")
        {
            $condition['user_businesses.state'] = $input['state'];
        }
        if($input['city']!="")
        {
            $condition['user_businesses.city'] = $input['city'];
        }
        if(isset($input['category']) && $input['category']!="")
        {
            $condition['bussiness_category_id'] = $input['category'];
        }
        /*if(isset($input['subcategory']) && $input['subcategory']!="")
        {
            $condition['bussiness_subcategory_id'] = $input['subcategory'];
        }*/
        if($input['page']=='user')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $users = User::select('users.full_name','users.email','users.country_code','users.mobile_number','user_businesses.city','user_businesses.state','user_businesses.country')->leftJoin('user_businesses', 'user_businesses.user_id', '=', 'users.id')->where($condition)->get()->toArray();
            }else
            {
                $users = User::select('users.full_name','users.email','users.country_code','users.mobile_number','user_businesses.city','user_businesses.state','user_businesses.country')->leftJoin('user_businesses', 'user_businesses.user_id', '=', 'users.id')->get()->toArray();
            }
        }elseif($input['page']=='business')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $users = UserBusiness::select('users.full_name','users.email','users.country_code','users.mobile_number','user_businesses.city','user_businesses.state','user_businesses.country')->leftJoin('users','users.id','=','user_businesses.user_id')->where($condition)->get()->toArray();
            }else
            {
                $users = UserBusiness::select('users.full_name','users.email','users.country_code','users.mobile_number','user_businesses.city','user_businesses.state','user_businesses.country')->leftJoin('users','users.id','=','user_businesses.user_id')->get()->toArray();
            }
        }
        $header = array('Full_Name','Email','Country_Code', 'Mobile_Number','City','State','Country');
        $delimiter=",";

        $filename = "export".time().".csv";

        header('Content-Type: application/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        $f = fopen('php://output', 'w');
        fputcsv($f, $header, $delimiter);

        foreach ($users as $line) { 
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter); 
        }
    }
} 
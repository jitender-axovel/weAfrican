<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\BussinessCategory;
use App\UserBusiness;
use App\CmsPage;
use App\User;
use App\CountryList;
use App\SecurityQuestion;
use App\BussinessSubcategory;
use App\UserPortfolio;
use Auth;
use Validator;
use App\Helper;
use Session;
use Illuminate\Support\Facades\Hash;

class UserBusinessPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Profile";
        $business = UserBusiness::where('user_id',Auth::id())->first();
        $businessPorfolio = UserPortfolio::where('user_id',Auth::id())->where('business_id',$business->id)->first();
        return view('business-portfolio.edit', compact('business', 'pageTitle', 'businessPorfolio'));
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
        //
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
        $input = $request->input();
        $portfolio = UserPortfolio::where('user_id',Auth::id())->first();
        $rules = array(
            'maritial_status' => 'required',
            'occupation' => 'required|string',
            'acedimic_status' => 'required',
            'key_skills' => 'required|string',
            'experience_years' => 'required',
            'experience_months' =>'required',
            'height_feets' => 'required',
            'height_inches' => 'required',
            'hair_type' => 'required',
            'hair_color' => 'required',
            'skin_color' => 'required',
            'professional_training' => 'sometimes',
            'institute_name' => 'required_if:professional_training,on',
            'portfolio_image_1' => 'required|image|mimes:jpg,png,jpeg',
            'portfolio_image_2' => 'image|mimes:jpg,png,jpeg',
            'portfolio_image_3' => 'image|mimes:jpg,png,jpeg',
            'portfolio_image_4' => 'image|mimes:jpg,png,jpeg',
            'portfolio_image_5' => 'image|mimes:jpg,png,jpeg',
            'main_image' => 'required',
            );
        if($portfolio->image!="" and $portfolio->image!=NULL)
        {
            $image = explode("|", $portfolio->image);
            if($image[0]!="")
            {
                $rules['portfolio_image_1'] = 'image|mimes:jpg,png,jpeg';
            }
        }else
        {
            $image = array();
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return back()->withErrors($validator)
                     ->withInput();
        }
        for($i=0;$i<=5;$i++)
        {
            if($request->hasFile('portfolio_image_'.($i+1))){
                if($request->file('portfolio_image_'.($i+1))->isValid())
                {
                    $file = $key = md5(uniqid(rand(), true));
                    $ext = $request->file('portfolio_image_'.($i+1))->
                        getClientOriginalExtension();
                    $image[$i] = $file.'.'.$ext; 

                    $fileName = $request->file('portfolio_image_'.($i+1))->move(config('image.portfolio_image_path'), $image[$i]);

                    $command = 'ffmpeg -i '.config('image.portfolio_image_path').$image[$i].' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.portfolio_image_path').'thumbnails/small/'.$image[$i];
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.portfolio_image_path').$image[$i].' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.portfolio_image_path').'thumbnails/medium/'.$image[$i];
                    shell_exec($command);

                    $command = 'ffmpeg -i '.config('image.portfolio_image_path').$image[$i].' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.portfolio_image_path').'thumbnails/large/'.$image[$i];
                    shell_exec($command);
                }
            }else
            {
                if($image[$i]=="" or  $image[$i]==NULL)
                {$image[$i] = "";}
            }
        }
        $input['image'] = implode("|", $image);
        $userPortfolio = array_intersect_key($input, UserPortfolio::$updatable);
        if(UserPortfolio::where('user_id',Auth::id())->exists())
        {
            $userPortfolio = UserPortfolio::where('user_id',Auth::id())->update($userPortfolio);
            if($userPortfolio)
            {
                $business = UserBusiness::where('user_id',Auth::id())->update(array('is_update'=>0));
                return redirect('register-business/'.$portfolio->business_id)->with('success', 'Your Portfolio has been updated');
            }else
            {
                return redirect('portfolio')->with('error', 'Error occured try again!');
            }
        }else
        {
            $userPortfolio = UserPortfolio::create($userPortfolio);
            $userPortfolio->save();
            if($userPortfolio)
            {
                $business = UserBusiness::where('user_id',Auth::id())->update(array('is_update'=>0));
                return redirect('register-business/'.$portfolio->business_id)->with('success', 'Your Portfolio has been updated');
            }else
            {
                return redirect('portfolio')->with('error', 'Error occured try again!');
            }
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
        //
    }
}

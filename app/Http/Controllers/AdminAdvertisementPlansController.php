<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AdvertisementPlan;
use Validator;

class AdminAdvertisementPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $page = 'Advertisement Plan- Admin';
        $advertisements = AdvertisementPlan::get();
        return view('admin.advertisements.index', compact('page', 'advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Advertisement Plan - Admin";
        return view('admin.advertisements.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->input(), AdvertisementPlan::$validater 
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return json_encode($validator->errors()->all());
            } 
        }

        $input = $request->input();
  
            $input = array_intersect_key($input,AdvertisementPlan::$updatable);
            $advertisement = new AdvertisementPlan();
            $advertisement->name = $input['name'];
            $advertisement->city_id = $input['city_id'];
            $advertisement->save();

            if($request->ajax()) {
                return json_encode(['status' => 'success','url' => url('admin/advertisement/plan')]);
            } else {
                return back();
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
        $page = "Edit Advertisement Plan - Admin";
        $advertisement = AdvertisementPlan::find($id);
        return view('admin.advertisements.edit',compact('advertisement','page'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',    
        ]);

        if ($validator->fails()) {
            return redirect('admin/advertisement/plan/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = $request->input();

        
            $input = array_intersect_key($input, AdvertisementPlan::$updatable);
            $advertisements = AdvertisementPlan::where('id',$id)->update($input);
        
            if($advertisements > 0 ){
                
                return redirect('admin/advertisement/plan')->with('success', 'Advertisement Updated successfully');
            } else {

                return back()->with('error', 'Advertisement could not be updated. Please try again.');
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
        $advertisement = AdvertisementPlan::findOrFail($id);
        if($advertisement->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' Advertisement Plan deleted  successfully',
            );
             return json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' Advertisement
                Plan can not be deleted.Please try again',
            );
             return json_encode($response);

        }
    }

    public function isActivated($id)
    {
        $advertisement=AdvertisementPlan::find($id);
       
        if($advertisement->is_activated == 0){ 
            $advertisement=AdvertisementPlan::where('id', $id)->update(['is_activated' => '1']);
            return redirect('admin/advertisement/plan')->with('success', 'Advertisement Plan activated successfully');

        } else if($advertisement->is_activated == 1){ 
           $advertisement=AdvertisementPlan::where('id', $id)->update(['is_activated' => '0']);
            return redirect('admin/advertisement/plan')->with('success', 'Advertisement Plan deactivated successfully');
        }   
    }
}

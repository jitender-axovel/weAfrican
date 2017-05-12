<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserBusiness;
use App\BussinessCategory;
use App\User;

class AdminUserBusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle  = 'Admin - User Business';
        $businesses = UserBusiness::get();
        return view('admin.business.index', compact('pageTitle', 'businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $pageTitle = "Admin - View Bussiness user";
        $business  = UserBusiness::find($id);
        return view('admin.business.view', compact('pageTitle', 'business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle  = "Admin - Edit User Bussiness Category";
        $business   = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked', 0)->get();
        return view('admin.business.edit', compact('pageTitle', 'business', 'categories'));
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

        $input = array_intersect_key($input, UserBusiness::$updatable);
         
        $user = UserBusiness::where('id', $id)->update($input);
            
        return redirect('admin/business')->with('success', 'User Business updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = UserBusiness::findOrFail($id);

        if ($user->delete()) {
            $response = [
                'status' => 'success',
                'message' => 'Business user deleted  successfully',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Business user can not be deleted.Please try again',
            ];
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $business             = UserBusiness::find($id);
        $business->is_blocked = !$business->is_blocked;
        $business->save();

        if ($business->is_blocked) {
            return redirect('admin/business')->with('success', 'User Bussiness has been blocked successfully');
        } else {
            return redirect('admin/business')->with('success', 'User Bussiness has been unblocked');
        }
    }

    public function identityProofVerfied($id)
    {
        $business                             = UserBusiness::find($id);
        $business->is_identity_proof_validate = ! $business->is_identity_proof_validate;
        $business->save();

        if ($business->is_identity_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        }
    }

    public function businessProofVerfied($id)
    {
        $business                             = UserBusiness::find($id);
        $business->is_business_proof_validate = ! $business->is_business_proof_validate;
        $business->save();

        if ($business->is_business_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        }
    }
}
=======
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserBusiness;
use App\BussinessCategory;
use App\User;

class AdminUserBusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - User Business';
        $businesses = UserBusiness::get();
        return view('admin.business.index', compact('pageTitle', 'businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
        $pageTitle = "Admin - View Bussiness user";
        $business = UserBusiness::find($id);
        return view('admin.business.view',compact('pageTitle','business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = "Admin - Edit User Bussiness Category";
        $business = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked',0)->get();
        return view('admin.business.edit',compact('pageTitle','business', 'categories'));
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

        $input = array_intersect_key($input, UserBusiness::$updatable);
         
        $user = UserBusiness::where('id',$id)->update($input);
            
        return redirect('admin/business')->with('success', 'User Business updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = UserBusiness::findOrFail($id);

        if($user->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business user deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business user can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $business = UserBusiness::find($id);
        $business->is_blocked = !$business->is_blocked;
        $business->save();

        if ($business->is_blocked) {
            return redirect('admin/business')->with('success', 'User Bussiness has been blocked successfully');
        } else {
            return redirect('admin/business')->with('success', 'User Bussiness has been unblocked');
        }
    }

    public function identityProofVerfied($id)
    {
        $business = UserBusiness::find($id);
        $business->is_identity_proof_validate = ! $business->is_identity_proof_validate;
        $business->save();

        if ( $business->is_identity_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        }
    }

    public function businessProofVerfied($id)
    {
        $business = UserBusiness::find($id);
        $business->is_business_proof_validate = ! $business->is_business_proof_validate;
        $business->save();

        if ( $business->is_business_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        }
    }
}
>>>>>>> 8c39c53ea005b053df66154f2fe2a9daa6de81c2

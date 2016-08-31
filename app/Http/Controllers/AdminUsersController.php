<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;


class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'User - Admin';
        $users = User::get();
        return view('admin.users.index', compact('page', 'users'));
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
        //
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
        if($user->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' User deleted  successfully',
            );
             return json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' User can not be deleted.Please try again',
            );
             return json_encode($response);

        }
    }

    public function getBlocked($id)
    {
        $user=User::find($id);
       
        if($user->is_blocked == 0){ 
            $user=user::where('id', $id)->update(['is_blocked' => '1']);
            return redirect('admin/users')->with('success', 'User blocked successfully');

        } else if($user->is_blocked == 1){ 
            $user=user::where('id', $id)->update(['is_blocked' => '0']);
            return redirect('admin/users')->with('success', 'User unblocked successfully');
        }   
    }
}

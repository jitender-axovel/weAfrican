<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\SecurityQuestion;
use App\Helper;
use Validator;

class AdminSecurityQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Security Questions';
        $securityquestions = SecurityQuestion::get();
        return view('admin.security-question.index', compact('pageTitle', 'securityquestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Security Question";
        return view('admin.security-question.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), SecurityQuestion::$validater );
        if ($validator->fails()) {
            return redirect('admin/security-question/create')->withErrors($validator)->withInput();
        }

        $input = $request->input();

        if($input['question'] == $input['confirm_question']) {
            $securityquestion = new SecurityQuestion();
            $securityquestion->question = $input['question'];

            $securityquestion->save();

            return redirect('admin/security-question')->with('success', 'New Security Question created successfully');
        }else
        {
            return redirect('admin/security-question/create')->with('error', 'Question and confirm question should be same');
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
        //
    }
}

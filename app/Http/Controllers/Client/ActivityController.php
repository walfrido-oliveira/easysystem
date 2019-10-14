<?php

namespace App\Http\Controllers\Client;

use App\Client\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

class ActivityController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activitys = Activity::where('active',1)->paginate(10);

        return view('adm.comercial.client.activity.index',compact('activitys'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
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
     * @param  \App\Client\TypeActivity  $typeActivity
     * @return \Illuminate\Http\Response
     */
    public function show(TypeActivity $typeActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client\TypeActivity  $typeActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeActivity $typeActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client\TypeActivity  $typeActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeActivity $typeActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client\TypeActivity  $typeActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeActivity $typeActivity)
    {
        //
    }
}

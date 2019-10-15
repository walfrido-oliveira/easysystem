<?php

namespace App\Http\Controllers\Client;

use App\Client\Cnae;
use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

class CnaeController extends Controller
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
     * Display a listing of the resource by name
     *
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        ///dd($request);
        //if ($request->ajax())
        //{

            $cnaes = Cnae::where('cnae_id','LIKE','%'.$request->search.'%')->get();

            if ($cnaes)
            {
                $term = $request->term;
                $sen['sucess'] = true;
                $sen['result'] = $cnaes->toArray();
                return Response::json( $sen );
            }
       // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Client\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function show(Cnae $cnae)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function edit(Cnae $cnae)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cnae $cnae)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cnae $cnae)
    {
        //
    }
}

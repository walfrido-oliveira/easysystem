<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User\UserHasClient;
use Illuminate\Http\Request;

class UserHasClientController extends Controller
{
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
     * @param  \App\UserHasClient  $userHasClient
     * @return \Illuminate\Http\Response
     */
    public function show(UserHasClient $userHasClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserHasClient  $userHasClient
     * @return \Illuminate\Http\Response
     */
    public function edit(UserHasClient $userHasClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserHasClient  $userHasClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserHasClient $userHasClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserHasClient  $userHasClient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = UserHasClient::find($id);
        $client ->delete();

        return response()->json([
            'data' => [
                'status' => true,
                'message' => 'Cliente removido com sucesso!'
            ]
        ]);
    }
}

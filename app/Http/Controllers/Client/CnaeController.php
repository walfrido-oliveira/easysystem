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
        if ($request->ajax())
        {

            $cnaes = Cnae::where('cnae_id','LIKE','%'.$request->search.'%')->get();

            if ($cnaes)
            {
                $term = $request->term;
                $sen['sucess'] = true;
                $sen['result'] = $cnaes->toArray();
                return Response::json( $sen );
            }
        }
    }
}

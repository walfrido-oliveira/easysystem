<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Taxation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use Response;

class TaxationController extends Controller
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

            $taxations = Taxation::where('name','LIKE','%'.$request->search.'%')->get();

            if ($taxations)
            {
                $term = $request->term;
                $sen['sucess'] = true;
                $sen['result'] = $taxations->toArray();
                return Response::json( $sen );
            }
        }
    }


}

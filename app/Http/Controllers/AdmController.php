<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Role\UserRole;

class AdmController extends Controller
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
     * Show the comercial view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('adm.comercial.index');
    }

    /**
     * Show the budget view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showBudget()
    {
        return view('adm.comercial.budget.index');
    }

    /**
     * Show the client view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showClient()
    {
        return view('adm.comercial.client.index');
    }


}

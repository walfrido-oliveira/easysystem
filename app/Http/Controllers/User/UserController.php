<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use App\User;
use Hash;

class UserController extends Controller
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

    public function index()
    {
        $users = User::where('active',1)->paginate(10);

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($users as $key => $value)
        {
            $hrefs[$value->id] =  route('users.edit',$value->id);
            $actions[$value->id] = route('users.destroy',$value->id);
        }

        $columns = array(
            array(
                "label" => "Nome",
                "name" => "name",
                "sort" => true,
                "uniqueId" => true,
                "initial_sort_order" => "desc",
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Email",
                "name" => "email",
                "sort" =>  true,
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Acões",
                "name" => "actions",
                "sort" => false,
            )
        );

        $sort = array(
            array(
            "name" => "id",
            "order" => "desc"
            )
        );

        return view('adm.acess.user.index',
        compact('users','hrefs','actions','columns','sort'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

     /**
     * Get clients list
     *
     * @return JSON
     */
    public function getUsers(Request $request)
    {
        //DB::enableQueryLog();
       // dd(json_decode($request));

        $json = json_decode($request->queryParams);

        if (isset($json->sort))
        {
            $sort = $json->sort;
        }

        if (isset($json->filters))
        {
            $filters = $json->filters;
        }

        if (isset($json->per_page))
        {
            $per_page = $json->per_page;
        }
        else
        {
            $per_page = 10;
        }

        $filtersArray = array();

        if (!empty($filters))
        {
            foreach ($filters as $key => $value)
            {
                $filtersArray[] = [$filters[$key]->name,'like','%'.$filters[$key]->text.'%'];
            }
        }

        if (!empty($sort) && !empty($filters))
        {
            $query = User::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = User::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = User::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }
}

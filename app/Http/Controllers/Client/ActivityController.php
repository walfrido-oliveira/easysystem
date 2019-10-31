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

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($activitys as $key => $value)
        {
            $hrefs[$value->id] =  route('activity.edit',$value->id);
            $actions[$value->id] = route('activity.destroy',$value->id);
        }

        $columns = array(
            array(
                "label" => "#",
                "name" => "id",
                "sort" => true,
                "uniqueId" => true,
                "initial_sort_order" => "desc",
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Nome",
                "name" => "name",
                "sort" =>  true,
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Acões",
                "name" => "actions",
                "sort" =>  false
            )
        );

        $sort = array(
            array(
            "name" => "id",
            "order" => "desc"
            )
        );

        return view('adm.comercial.client.activity.index',
            compact('activitys','hrefs','actions','columns','sort'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.comercial.client.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ],
        [
            'name.required' => 'O campo nome é obrigatório'
        ]
        );

        Activity::create($request->all());

        return redirect()->route('activity.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client\Activity  $Activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return view('adm.comercial.client.activity.show',compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client\Activity  $Activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        return view('adm.comercial.client.activity.edit',compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client\Activity  $Activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'name' => 'required|max:255',
        ],
        [
            'name.required' => 'O campo nome é obrigatório'
        ]
        );

        $activity->update($request->all());

        return redirect()->route('activity.index')
                        ->with('success','Atividade adicionada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client\Activity  $Activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activity.index')
                        ->with('success','Atividade deletada com sucesso');
    }

    /**
     * Get activitys list
     *
     * @return JSON
     */
    public function getActivitys(Request $request)
    {

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
            $query = Activity::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Activity::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Activity::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }
}

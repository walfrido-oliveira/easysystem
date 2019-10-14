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
}

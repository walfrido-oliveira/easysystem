<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

class AreaController extends Controller
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
        $areas = Area::where('active',1)->paginate(10);

        return view('adm.comercial.budget.area.index',compact('areas'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.comercial.budget.area.create');
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

        Area::create($request->all());

        return redirect()->route('area.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orcamento\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        return view('adm.comercial.budget.area.show',compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orcamento\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('adm.comercial.budget.area.edit',compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orcamento\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|max:255',
        ],
        [
            'name.required' => 'O campo nome é obrigatório'
        ]
        );

        $area->update($request->all());

        return redirect()->route('area.index')
                        ->with('success','Área adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orcamento\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('area.index')
                        ->with('success','Área deletado com sucesso');
    }
}

<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Taxation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Taxations = Taxation::where('active',1)->paginate(10);

        return view('adm.comercial.budget.Taxation.index',compact('Taxations'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.comercial.budget.Taxation.create');
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
            'name' => 'required|max:255|unique:Taxations',
        ],
        [
            'name.required' => 'O campo nome é obrigatório'
        ]
        );

        Taxation::create($request->all());

        return redirect()->route('Taxation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orcamento\Taxation  $Taxation
     * @return \Illuminate\Http\Response
     */
    public function show(Taxation $Taxation)
    {
        return view('adm.comercial.budget.Taxation.show',compact('Taxation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orcamento\Taxation  $Taxation
     * @return \Illuminate\Http\Response
     */
    public function edit(Taxation $Taxation)
    {
        return view('adm.comercial.budget.Taxation.edit',compact('Taxation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orcamento\Taxation  $Taxation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxation $Taxation)
    {
        $request->validate([
            'name' => 'required|max:255|unique:Taxations',
        ],
        [
            'name.required' => 'O campo nome é obrigatório'
        ]
        );

        $Taxation->update($request->all());

        return redirect()->route('Taxation.index')
                        ->with('success','Área adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orcamento\Taxation  $Taxation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxation $Taxation)
    {
        $Taxation->delete();

        return redirect()->route('Taxation.index')
                        ->with('success','Área deletado com sucesso');
    }
}

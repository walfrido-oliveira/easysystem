<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use App\Budget\Area;

class ServiceController extends Controller
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
        $services = Service::where('active',1)->paginate(10);

        return view('adm.comercial.budget.service.index',compact('services'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::where('active',1)->get();

        return view('adm.comercial.budget.service.create',compact('areas'));
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
            'desc' => 'required|max:255',
            'area_id' => 'required',
            'type' => 'required|max:255',
            'local' => 'required|max:255',
            'value' => 'required|numeric',
            'range' => 'required',
        ],
        [
            'desc.required' => 'O campo descrição é obrigatório',
            'area_id.required' => 'O campo área é obrigatório',
            'type' => 'O campo tipo é obrigatório',
            'local.required' => 'O campo local é obrigatório',
            'value.required' => 'O campo valor é obrigatório',
            'range.required' => 'O campo faixa é obrigatório'
        ]
        );

        Service::create($request->all());

        return redirect()->route('service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('adm.comercial.budget.service.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $areas = Area::where('active',1)->get();
        return view('adm.comercial.budget.service.edit',compact('service','areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'desc' => 'required|max:255',
            'area_id' => 'required',
            'type' => 'required|max:255',
            'local' => 'required|max:255',
            'value' => 'required|numeric',
            'range' => 'required',
        ],
        [
            'desc.required' => 'O campo descrição é obrigatório',
            'area_id.required' => 'O campo área é obrigatório',
            'type' => 'O campo tipo é obrigatório',
            'local.required' => 'O campo local é obrigatório',
            'value.required' => 'O campo valor é obrigatório',
            'range.required' => 'O campo faixa é obrigatório'
        ]
        );

        $service->update($request->all());

        return redirect()->route('service.index')
                        ->with('success','Serviço adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
                        ->with('success','Serviço deletado com sucesso');
    }
}

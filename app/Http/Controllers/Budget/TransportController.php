<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Transport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

class TransportController extends Controller
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
        $transports = Transport::where('active',1)->paginate(10);

        return view('adm.comercial.budget.transport.index',compact('transports'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.comercial.budget.transport.create');
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
            'name' => 'required|max:255|unique:transports',
        ],
        [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome permite no máximo 255 caracteres',
            'name.unique' => 'O campo nome deve ser único',
        ]);

        Transport::create($request->all());

        return redirect()->route('transport.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function show(Transport $transport)
    {
        return view('adm.comercial.budget.transport.show',compact('transport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function edit(Transport $transport)
    {
        return view('adm.comercial.budget.transport.edit',compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transport $transport)
    {
        $request->validate([
            'name' => 'required|max:255|unique:transports',
        ],
        [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome permite no máximo 255 caracteres',
            'name.unique' => 'O campo nome deve ser único',
        ]);

        $transport->update($request->all());

        return redirect()->route('transport.index')
                        ->with('success','Forma de transporte adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transport $transport)
    {
        $transport->delete();

        return redirect()->route('transport.index')
                        ->with('success','Forma de transporte deletada com sucesso');
    }
}

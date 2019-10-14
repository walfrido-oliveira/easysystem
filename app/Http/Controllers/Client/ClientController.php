<?php

namespace App\Http\Controllers\Client;

use App\Client\Client;
use App\Client\Activity ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use Storage;
use Image;
use \App\UF;

class ClientController extends Controller
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
        $clients = Client::where('active',1)->paginate(10);

        return view('adm.comercial.client.client.index',compact('clients'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activitys = Activity::where('active',1)->get();
        $ufs = UF::all();
        return view('adm.comercial.client.client.create',compact('activitys','ufs'));
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
            'cnpj' => 'required|max:14|unique:clients',
            'razao_social' => 'required|max:255',
            'nome_fantasia' => 'required|max:255',
            'id_type_client_activity' => 'required'
        ],
        [
            'cnpj.required' => 'O campo CNPJ é obrigatório',
            'cnpj.max' => 'O CNPJ não está em um formato correto',
            'cnpj.unique' => 'CNPJ já cadastrado',
            'id_type_client_activity.required' => 'O campo tipo atividade é obrigatório'
        ]
        );

        $data = $request->all();
        $client = Client::create($data);

        if (! is_null($request->logo))
        {
            $logo = $request->logo->store('clients/' . str_pad((string)$client->id, 20, "0", STR_PAD_LEFT));
            $data['logo'] = $logo;
        }

        $client->update($data);
        return redirect()->route('client.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('adm.comercial.client.client.show',compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $activitys = Activity::where('active',1)->get();
        $ufs = UF::all();
        return view('adm.comercial.client.client.edit',compact('client','activitys','ufs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'cnpj' => 'required|max:14|unique:clients,cnpj,'.$client->id,
            'razao_social' => 'required|max:255',
            'nome_fantasia' => 'required|max:255',
            'id_type_client_activity' => 'required'
        ],
        [
            'cnpj.required' => 'O campo CNPJ é obrigatório',
            'cnpj.max' => 'O CNPJ não está em um formato correto',
            'cnpj.unique' => 'CNPJ já cadastrado',
            'id_type_client_activity.required' => 'O campo tipo atividade é obrigatório'
        ]
        );

        $data = $request->all();

        if (! is_null($request->logo))
        {
            $logo = $request->logo->store('clients/' . str_pad((string)$client->id, 20, "0", STR_PAD_LEFT));
            $data['logo'] = $logo;
        }

        $client->update($data);

        return redirect()->route('client.index')
                        ->with('success','Cliente adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('client.index')
                        ->with('success','Cliente deletado com sucesso');
    }
}

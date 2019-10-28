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
Use DB;

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

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($clients as $key => $value)
        {
            $hrefs[$value->id] =  route('client.edit',$value->id);
            $actions[$value->id] = route('client.destroy',$value->id);
        }

        $columns = array(
            [
                "label" => "#",
                "name" => "id",
                "filter" =>
                [
                    "type" => "simple",
                    "placeholder" => "id",
                    "case_sensitive" => "true",
                    "showClearButton" => "true",
                    "filterOnPressEnter" => "true",
                    "debounceRate" => "1000",
                    "placeholder" => "Código do Cliente",
                ],
                "sort" => "true",
                "uniqueId" => "true",
            ],
            [
                "label" => "Razão Social",
                "name" => "razao_social",
                "filter" =>
                [
                    "type" => "simple",
                    "placeholder" => "Razão Social",
                    "case_sensitive" => "true",
                    "showClearButton" => "true",
                    "filterOnPressEnter" => "true",
                    "debounceRate" => "1000",
                    "placeholder" => "Razão Social",
                ],
                "sort" => "true",
            ],
            [
                "label" => "Ações",
                "name" => "actions",
                "sort" =>  "false",
            ]
            );

        $sort = array(
            array(
            "name" => "id",
            "order" => "desc"
            )
        );

        return view('adm.comercial.client.client.index',
        compact('clients','hrefs','actions','columns','sort'))
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
        $request->validate($this->rules(), $this->mesagens());

        $data = $this->cleanData($request->all());

        $client = Client::create($data);

        if (! is_null($request->logo))
        {
            $logo = $request->logo->store('clients/' .
                                           str_pad((string)$client->id, 20, "0", STR_PAD_LEFT));
            $data['logo'] = $logo;
        }

        $client->update($data);

        return redirect()->route('client.index')
            ->with('success','Cliente adicionado com sucesso');
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

        if ($client->simples_nacional)
        {
            $client->simples_nacional = 'checked';
        } else {
            $client->simples_nacional = '';
        }

        if ($client->produtor_rural)
        {
            $client->produtor_rural = 'checked';
        } else {
            $client->produtor_rural = '';
        }

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

        $request->validate($this->rules(), $this->mesagens());

        $data = $this->cleanData($request->all());

        if (! is_null($request->logo))
        {
            $logo = $request->logo->store('clients/' .
                                          str_pad((string)$client->id, 20, "0", STR_PAD_LEFT));
            $data['logo'] = $logo;
        }

        $client->update($data);

        return redirect()->route('client.index')
                        ->with('success','Cliente atualizado com sucesso');
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

    /**
     * Remove caracters
     *
     * @return array
     */
    private function cleanData($data)
    {
        if (isset($data['simples_nacional']))
        {
            $data['simples_nacional'] = true;
        } else {
            $data['simples_nacional'] = false;
        }

        if (isset($data['produtor_rural']))
        {
            $data['produtor_rural'] = true;
        } else {
            $data['produtor_rural'] = false;
        }

        $data['cnpj'] = str_replace('.','',$data['cnpj']);
        $data['cnpj'] = str_replace('/','',$data['cnpj']);
        $data['cnpj'] = str_replace('-','',$data['cnpj']);

        $data['cep'] = str_replace('-','',$data['cep']);
        $data['cep'] = str_replace('.','',$data['cep']);

        $data['phone'] = str_replace('-','',$data['phone']);
        $data['phone_2'] = str_replace('-','',$data['phone_2']);

        return $data;
    }

    /**
     * Set rules validation
     *
     * @return array
     */
    private function rules()
    {
        return array(
            'cnpj' => 'required|max:18|unique:clients',
            'razao_social' => 'required|max:255',
            'nome_fantasia' => 'required|max:255',
            'id_type_client_activity' => 'required',
            'ddd' => 'max:99',
            'phone' => 'max:255',
            'contact' => 'max:255',
            'adress' => 'max:255',
            'number' => 'max:255',
            'district' => 'max:255',
            'complement' => 'max:255',
            'state' => 'max:2',
            'city' => 'max:255',
            'ddd_2' => 'max:99',
            'phone_2' => 'max:99',
            'mail' => 'max:255',
            'website' => 'max:255',
            'ie' => 'max:255',
            'im' => 'max:255',
            'suframa' => 'max:255',
            'cnae' => 'max:255',
            'logo' => 'max:255',
            'obs' => 'max:255',
        );
    }

    /**
     * Set mesagens validation
     *
     * @return array
     */
    private function mesagens()
    {
        return array(
            'cnpj.required' => 'O campo CNPJ é obrigatório',
            'cnpj.max' => 'O CNPJ não está em um formato correto',
            'cnpj.unique' => 'CNPJ já cadastrado',
            'id_type_client_activity.required' => 'O campo tipo atividade é obrigatório',
            'ddd.max' => 'O campo ddd permite no máximo o valor 99',
        );
    }

    /**
     * Get clients list
     *
     * @return JSON
     */
    public function getCliets(Request $request)
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
            $query = Client::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Client::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Client::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }
}

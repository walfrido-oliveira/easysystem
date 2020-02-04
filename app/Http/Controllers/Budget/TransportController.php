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

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($transports as $key => $value)
        {
            $hrefs[$value->id] =  route('transport.edit',$value->id);
            $actions[$value->id] = route('transport.destroy',$value->id);
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
            )
        );

        $sort = array(
            array(
            "name" => "id",
            "order" => "desc"
            )
        );

        return view('adm.comercial.budget.transport.index',
        compact('transports','hrefs','actions','columns','sort'))
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

        flash('Transporte adicionado com sucesso!')->success();

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

        flash('Transporte atualizado com sucesso!')->success();

        return redirect()->route('transport.index');
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

        flash('Transporte deletado com sucesso!')->success();

        return redirect()->route('transport.index');
    }

    /**
     * Get transpots list
     *
     * @return JSON
     */
    public function getTransports(Request $request)
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
            $query = Transport::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Transport::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Transport::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }
}

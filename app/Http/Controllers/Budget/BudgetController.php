<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Area;
use App\Budget\BudgetHasService;
use App\Budget\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Budget\Budget;
use App\Budget\Payment;
use App\Budget\Transport;
use App\Budget\BudgetFiles;
use Storage;
use File;
use \App\Role\UserRole;
use App\User\UserHasClient;

class BudgetController extends Controller
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
        $budgets =  Budget::paginate(10);

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($budgets as $key => $value)
        {
            $hrefs[$value->id] =  route('budget.edit',$value->id);
            $actions[$value->id] = route('budget.destroy',$value->id);
        }

        $columns = array(
            array(
                "label" => "#",
                "name" => "internal_id",
                "sort" => "true",
                "uniqueId" => true,
                "initial_sort_order" => "desc",
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Cliente",
                "name" => "client.razao_social",
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
            "name" => "budgets.id",
            "order" => "desc"
            )
        );

        return view('adm.comercial.budget.budget.index',
        compact('budgets','hrefs','actions','columns','sort'))
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

        $services = Service::where('active',1)->get();

        $payments = Payment::where('active',1)->get();

        $transports = Transport::where('active',1)->get();

        return view('adm.comercial.budget.budget.create',compact('areas','services','payments','transports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $budget = Budget::create($request->all());

        Storage::disk('local')->makeDirectory($budget->path);

        flash('Orçamento adicionado com sucesso')->success();

        return redirect()->route('budget.edit', $budget->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        return view('adm.comercial.budget.budget.show',compact('budget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        $files = BudgetFiles::where('budget_id',$budget->id)->get();

        $areas = Area::where('active',1)->get();

        $services = Service::where('active',1)->get();

        $payments = Payment::where('active',1)->get();

        $transports = Transport::where('active',1)->get();

        return view('adm.comercial.budget.budget.edit',
                compact('budget','files','areas','services','payments','transports'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        $request->validate($this->rules());

        $budget->update($request->all());

        Storage::disk('local')->makeDirectory($budget->path);

        flash('Orçamento alterado com sucesso')->success();

        return redirect()->route('budget.edit', $budget->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        foreach ($budget->files as $key => $value) {
            Storage::delete($value->url);
            $value->delete();
        }

        $budget->delete();

        flash('Orçamento deletada com sucesso!')->success();

        return redirect()->route('budget.index');
    }

    /**
     * Get budgets list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function getBudgets(Request $request)
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

        $user = auth()->user();
        $clients = UserHasClient::where('user_id', $user->id)->get();
        $clients_id = [];

        foreach ($clients as $key => $value) {
            $clients_id[] = $value->client_id;
        }

        if (!empty($sort) && !empty($filters))
        {
            $query = Budget::with('client')
            ->where(function($q) use($filtersArray) {
                if($filtersArray)
                {
                    foreach ($filtersArray as $key => $value)
                    {
                        if(in_array('client.razao_social', $value))
                        {
                            $q->whereHas('client', function($q) use($value) {
                                $q->where('clients.razao_social', $value[1], $value[2]);
                            });
                        }
                        if(in_array('internal_id', $value))
                        {
                            $q->where($value[0], $value[1], $value[2]);
                        }
                    }
                }
            })
            ->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Budget::with('client')
            ->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Budget::with('client')
            ->where(function($q) use($filtersArray) {
                if($filtersArray)
                {
                    foreach ($filtersArray as $key => $value)
                    {
                        if(in_array('client.razao_social', $value))
                        {
                            $q->whereHas('client', function($q) use($value) {
                                $q->where('clients.razao_social', $value[1], $value[2]);
                            });
                        }
                        if(in_array('internal_id', $value))
                        {
                            $q->where($value[0], $value[1], $value[2]);
                        }
                    }
                }

            })
            ->paginate($per_page);
        }

        $hrefs = array();
        $actions = array();

        foreach ($query as $key => $value)
        {
            $hrefs[$value->id] =  route('budget.edit',$value->id);
            $actions[$value->id] = route('budget.destroy',$value->id);
        }

        return [
            'data' => $query,
            'hrefs' => $hrefs,
            'actions' => $actions
        ];
    }

    /**
     * Set rules validation
     *
     * @return array
     */
    private function rules()
    {
        return array(
            'contact' => 'required|max:255',
            'client_id' => 'required',
            'phone' => 'required|max:255',
            'mail' => 'required|max:255',
            'payment_id' => 'required',
            'transport_id' => 'required',
            'files.*' => 'mimes:pdf,doc,docx,xlsx,dot'
        );

    }
}

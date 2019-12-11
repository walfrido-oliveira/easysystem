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

class BudgetController extends Controller
{

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
        $budgets = Budget::paginate(10);

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
            "name" => "id",
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

        $files = $request->file('files_budget');

        if($request->hasFile('files_budget')) {
            foreach ($files as $value) {
                $url = $value->store($budget->path);
                $name = $value->getClientOriginalName();
                $mime = $value->getMimeType();
                BudgetFiles::create([
                    'budget_id' => $budget->id,
                    'url' => $url,
                    'name' => $name,
                    'mime' => $mime
                ]);
            }
        }

        return redirect()->route('budget.index')
        ->with('success','Orçamento adicionado com sucesso');
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

        return view('adm.comercial.budget.budget.edit',compact('budget','files','areas','services','payments','transports'));
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

        $files = $request->file('files_budget');

        if($request->hasFile('files_budget')) {
            foreach ($files as $value) {
                $url = $value->store($budget->path);
                $name = $value->getClientOriginalName();
                $mime = $value->getMimeType();
                BudgetFiles::create([
                    'budget_id' => $budget->id,
                    'url' => $url,
                    'name' => $name,
                    'mime' => $mime
                ]);
            }
        }

        return redirect()->route('budget.index')
        ->with('success','Orçamento atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }

    /**
     * Get budgets list
     *
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

        if (!empty($sort) && !empty($filters))
        {
            $query = Budget::with('client')->where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Budget::with('client')->where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Budget::with('client')->where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
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

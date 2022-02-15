<?php

namespace App\Http\Controllers\User;

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
        $this->middleware('check_user_role:' . UserRole::ROLE_USER);
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
        $user = auth()->user();
        $clients = UserHasClient::where('user_id', $user->id)->get();
        $clients_id = [];

        foreach ($clients as $key => $value) {
            $clients_id[] = $value->client_id;
        }

        $budgets =  Budget::whereIn('client_id', $clients_id)->paginate(10);

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($budgets as $key => $value)
        {
            $hrefs[$value->id] =  route('user.budget.show',$value->id);
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

        return view('user.budget.budget.index',
        compact('budgets','hrefs','actions','columns','sort'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
   }

     /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $budget = Budget::find($id);

        $files = BudgetFiles::where('budget_id',$budget->id)->get();

        $areas = Area::where('active',1)->get();

        $services = Service::where('active',1)->get();

        $payments = Payment::where('active',1)->get();

        $transports = Transport::where('active',1)->get();

        return view('user.budget.budget.show',
        compact('budget', 'areas', 'services','payments', 'transports', 'files'));
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
            $query = Budget::with('client')->where($filtersArray)->whereIn('client_id', $clients_id)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Budget::with('client')->whereIn('client_id', $clients_id)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Budget::with('client')->where($filtersArray)->whereIn('client_id', $clients_id)->paginate($per_page);
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

}

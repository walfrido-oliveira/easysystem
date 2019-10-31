<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;

class PaymentController extends Controller
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
        $payments = Payment::where('active',1)->paginate(10);

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($payments as $key => $value)
        {
            $hrefs[$value->id] =  route('payment.edit',$value->id);
            $actions[$value->id] = route('payment.destroy',$value->id);
        }

        $columns = array(
            array(
                "label" => "#",
                "name" => "id",
                "sort" => "true",
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

        return view('adm.comercial.budget.payment.index',
            compact('payments','hrefs','actions','columns','sort'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.comercial.budget.payment.create');
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
            'name' => 'required|max:255|unique:payments',
        ],
        [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome permite no máximo 255 caracteres',
            'name.unique' => 'O campo nome deve ser único',
        ]);

        Payment::create($request->all());

        return redirect()->route('payment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return view('adm.comercial.budget.payment.show',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('adm.comercial.budget.payment.edit',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'name' => 'required|max:255|unique:payments',
        ],
        [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome permite no máximo 255 caracteres',
            'name.unique' => 'O campo nome deve ser único',
        ]);

        $payment->update($request->all());

        return redirect()->route('payment.index')
                        ->with('success','Forma de pagamento adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment.index')
                        ->with('success','Forma de pagamento deletada com sucesso');
    }

    /**
     * Get payments list
     *
     * @return JSON
     */
    public function getPayments(Request $request)
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
            $query = Payment::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = Payment::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = Payment::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }
}

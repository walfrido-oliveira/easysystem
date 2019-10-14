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

        return view('adm.comercial.budget.budget.index',compact('budgets'))
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

        return view('budget.index',compact('areas','services','payments','transports'));
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
            'contact' => 'required|max:255',
            'client' => 'required|max:255',
            'client_id' => 'required|max:255',
            'phone' => 'required|max:255',
            'mail' => 'required|max:255',
            'payment_id' => 'required',
            'transport_id' => 'required',
            'services' => 'required',
        ],
        [
            'contact.required' => 'O campo contato é obrigatório',
            'client.required' => 'O campo empresa é obrigatório',
            'cliente_id.required' => 'O campo CNPJ é obrigatório',
            'phone.required' => 'O telefone é obrigatório',
            'mail.required' => 'O campo email é obrigatório',
            'payment_id.required' => 'Selecione uma forma de pagamento',
            'transport_id.required' => 'Seleciona uma forma de transporte',
            'services.required' => 'Selecione um serviço',
        ]);

        $budget = Budget::create($request->all());

        $data = $request->all()['services'];

        foreach ($data as $key => $value) {
            BudgetHasService::create([
                'budget_id' => $budget->id,
                'service_id' => $value['service_id'],
                'count' => $value['count'],
                'obs' => $value['obs'],
            ]
            );
        }

        return redirect()->route('home');
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
        //
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
        //
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
}

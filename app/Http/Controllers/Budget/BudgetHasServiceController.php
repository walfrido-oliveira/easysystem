<?php

namespace App\Http\Controllers\Budget;

use App\Budget\BudgetHasService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetHasServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        BudgetHasService::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\BudgetHasService  $budgetHasService
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetHasService $budgetHasService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\BudgetHasService  $budgetHasService
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetHasService $budgetHasService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\BudgetHasService  $budgetHasService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetHasService $budgetHasService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\BudgetHasService  $budgetHasService
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetHasService $budgetHasService)
    {
        //
    }
}

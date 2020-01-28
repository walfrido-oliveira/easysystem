<?php

namespace App\Http\Controllers\Budget;

use App\Budget\BudgetFiles;
use App\Budget\Budget;
use Illuminate\Http\Request;
use \App\Role\UserRole;
use App\Http\Controllers\Controller;
use App\User;
use App\User\UserHasClient;

class BudgetFilesController extends Controller
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
     * Upload file into budget folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function upload(Request $request)
    {
        $files = $request->file();

        $id = $request->id;

        $budget = Budget::find($id);

        $budget_files_id = [];

        $users = UserHasClient::where('client_id', $budget->client_id)->get();

        foreach ($files as $value) {
            $url = $value->store($budget->path);
            $name = $value->getClientOriginalName();
            $mime = $value->getMimeType();
            $budget_files_id[] = ["id" => BudgetFiles::create([
                                            'budget_id' => $budget->id,
                                            'url' => $url,
                                            'name' => $name,
                                            'mime' => $mime
                                            ])->id,
                                  "name" => $name];

            User::sendNewFileEmails($users, $budget, $name);
        }

        return ['budget_files_id' => $budget_files_id];
    }


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
        //
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
     * @param  \App\Budget\BudgetFiles  $budgetFiles
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetFiles $budgetFiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\BudgetFiles  $budgetFiles
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetFiles $budgetFiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\BudgetFiles  $budgetFiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetFiles $budgetFiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\BudgetFiles  $budgetFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetFiles $budgetFiles)
    {
        //
    }
}

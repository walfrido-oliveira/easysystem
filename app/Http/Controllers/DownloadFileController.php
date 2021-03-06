<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Budget\Budget;
use App\User\UserHasClient;
use App\Budget\BudgetFiles;
use \App\Role\UserRole;
use App\Http\Controllers\Controller;

class DownloadFileController extends Controller
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
     * Download file
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $file = BudgetFiles::Find($id);
        $url = $file->url;

        $client_id = $file->budget->client->id;

        $user = auth()->user();
        $clients = UserHasClient::where('user_id', $user->id)->where('client_id', $client_id)->get();

        if(count($clients) == 0 && $user->type != 'adm') {
            abort(404,'Arquivo não localizado');
        }

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $filePath = $storagePath . $url;

        if (! file_exists($filePath)) {
            abort(404,'Arquivo não localizado');
        }

        return response()->download($filePath,$file->name);

    }

}

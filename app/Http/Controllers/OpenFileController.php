<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Budget\BudgetFiles;
use App\UserHasClient;

class OpenFileController extends Controller
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
     * Open file
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $file = BudgetFiles::Find($id);
        $url = $file->url;

        $user = auth()->user();
        $clients = UserHasClient::where('user_id', $user->1)->get();


        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $filePath = $storagePath . $url;

        if (! file_exists($filePath)) {
            abort(404,'Arquivo não localizado');
        }

        return response()->file($filePath);

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Budget\BudgetFiles;

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
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $file = BudgetFiles::Find($id);
        $url = $file->url;

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $filePath = $storagePath . $url;

        if (! file_exists($filePath)) {
            abort(404,'Arquivo não localizado');
        }

        return response()->download($filePath,$file->name);

    }

}

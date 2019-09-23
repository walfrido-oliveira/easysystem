<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\User;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }
}

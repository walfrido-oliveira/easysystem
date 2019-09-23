<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::resource('users','UserController')->middleware('auth');

Route::get('/home', function() {
    if (Auth::user()->type === 'adm')
    {
        return view('adms.home');
    }
    if (Auth::user()->type === 'user')
    {
        return view('users.home');
    }
})->middleware('check_user_role:' . \App\Role\UserRole::ROLE_FINANCE);

Route::resource('orcamentos','Orcamento\OrcamentoController');



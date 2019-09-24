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

Route::resource('users','User\UserController')->middleware('auth');

Route::get('/home', function() {
    if (Auth::user()->type === 'adm')
    {
        return view('adm.home');
    }
    if (Auth::user()->type === 'user')
    {
        return view('user.home');
    }
})->middleware('auth')->name('home');

Route::get('/home/comercial','AdmController@index')->middleware('auth')->name('home_comercial');
Route::get('/home/comercial/orcamento','AdmController@showBudget')->middleware('auth')->name('comercial_budget');
Route::resource('/home/comercial/orcamento/area','Budget\AreaController')->middleware('auth');

Route::resource('orcamento','Budget\BudgetController');



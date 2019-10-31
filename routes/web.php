<?php

use \App\Role\UserRole;

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

Route::get('storage/app/{filename?}', function ($filename)
{
    $path = storage_path('app/' . $filename);
    $path = str_replace('\\','/',$path);

    if (!File::exists($path)) {
        abort(404,'Arquivo não localizado');
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('filename', '(.*)');


Route::get('/home/comercial/client/cnae/search','Client\CnaeController@search')->middleware('auth');
Route::get('/helper/cep','Helper\HelperController@getAdressInformations')->middleware('auth');
Route::get('/helper/cnpj','Helper\HelperController@getCNPJInformations')->middleware('auth');
Route::get('/home/comercial/budget/service_type/search','Budget\ServiceTypeController@search')->middleware('auth');

Route::get('/home/comercial','AdmController@index')->middleware('auth')->name('home.comercial');
Route::get('/home/comercial/budget','AdmController@showBudget')->middleware('auth')->name('comercial.budget');
Route::get('/home/comercial/client','AdmController@showClient')->middleware('auth')->name('comercial.client');
Route::get('orcamento','Budget\BudgetController@create')->name('orcamento.create');
Route::post('orcamento/store','Budget\BudgetController@store')->name('orcamento.store');

Route::resource('users','User\UserController')->middleware('auth');

//Comercial resources
Route::resource('/home/comercial/budget/area','Budget\AreaController')->middleware('auth');
Route::resource('/home/comercial/budget/service','Budget\ServiceController')->middleware('auth');
Route::resource('budget','Budget\BudgetController')->except(['create', 'store'])->middleware('auth')
    ->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
Route::resource('/home/comercial/budget/payment','Budget\PaymentController')->middleware('auth');
Route::resource('/home/comercial/budget/transport','Budget\TransportController')->middleware('auth');

Route::resource('/home/comercial/client/client','Client\ClientController')->middleware('auth');
Route::resource('/home/comercial/client/activity','Client\ActivityController')->middleware('auth');

//tables routes
Route::get('/home/comercial/client/clients','Client\ClientController@getCliets')->middleware('auth');
Route::get('/home/comercial/client/activitys','Client\ActivityController@getActivitys')->middleware('auth');

Route::get('/home/comercial/budget/areas','Budget\AreaController@getAreas')->middleware('auth');
Route::get('/home/comercial/budget/services','Budget\ServiceController@getServices')->middleware('auth');
Route::get('/home/comercial/budget/payments','Budget\PaymentController@getPayments')->middleware('auth');
Route::get('/home/comercial/budget/transports','Budget\TransportController@getTransports')->middleware('auth');
Route::get('/home/comercial/budget/budgets','Budget\BudgetController@getBudgets')->middleware('auth');



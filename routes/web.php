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

Route::get('/home/comercial','AdmController@index')->middleware('auth')->name('home.comercial');
Route::get('/home/comercial/orcamento','AdmController@showBudget')->middleware('auth')->name('comercial.budget');
Route::get('/home/comercial/client','AdmController@showClient')->middleware('auth')->name('comercial.client');
Route::get('orcamento','Budget\BudgetController@create')->name('orcamento.create');
Route::post('orcamento/store','Budget\BudgetController@store')->name('orcamento.store');

Route::resource('users','User\UserController')->middleware('auth');
Route::resource('/home/comercial/orcamento/area','Budget\AreaController')->middleware('auth');
Route::resource('/home/comercial/orcamento/service','Budget\ServiceController')->middleware('auth');
Route::resource('budget','Budget\BudgetController')->except([
    'create', 'store'
])->middleware('auth')->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
Route::resource('/home/comercial/orcamento/payment','Budget\PaymentController')->middleware('auth');
Route::resource('/home/comercial/orcamento/transport','Budget\TransportController')->middleware('auth');

Route::resource('/home/comercial/client/client','Client\ClientController')->middleware('auth');
Route::resource('/home/comercial/client/activity','Client\ActivityController')->middleware('auth');

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




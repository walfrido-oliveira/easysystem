<?php

use \App\Role\UserRole;
use Elibyy\TCPDF\Facades\TCPDF;

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

Route::get('test', function() {

    $certificate = 'file://'. realpath('../storage/cert/certificate.crt');
    $private_key = 'file://'. realpath('../storage/cert/out.key');
    $image_signature = realpath('../storage/cert/signature.png');
    $pdf_path = realpath('../storage/files/teste.pdf');

    $pdf = new TCPDF();

    // set additional information
    $info = array(
    'Name' => 'Name of PDF',
    'Location' => '',
    'Reason' => 'Proof of author',
    'ContactInfo' => 'info@example.co.za',
    );

    // set document signature
    $pdf::setSignature($certificate, $private_key, '', '', 2, $info);

    // set font
    $pdf::SetFont('helvetica', '', 12);

    //set margin
    $pdf::SetMargins(0,0,0,false);
    $pdf::setCellPaddings(0,0,0,0);
    $pdf::setFooterMargin(0);

    // add a page
    $pdf::AddPage();

    // print a line of text
    $text = '<p>Teste de assinatura de certificado</p>';
    $pdf::writeHTML($text, true, 0, true, 0);

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // *** set signature appearance ***

    // create content for signature (image and/or text)
    $pdf::Image($image_signature, 180, 261.5, 15, 15, 'PNG');

    // define active area for signature appearance
    $pdf::setSignatureAppearance(180, 261.5, 15, 15);
    //dd($pdf::getMargins())  ;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // *** set an empty signature appearance ***
    //$pdf::addEmptySignatureAppearance(180, 80, 15, 15);

    // ---------------------------------------------------------

    //Close and output PDF document
    //$pdf->Output('example_052.pdf', 'D');

    //$pdf::Output($pdf_path, 'F');

    $pdf::Output();


});

Auth::routes(['register' => false, 'verify' => true]);

Route::get('/home', function() {
    if (Auth::user()->type === 'adm')
    {
        return view('adm.home');
    }
    if (Auth::user()->type === 'user')
    {
        return view('user.home');
    }
})->middleware(['verified','auth'])->name('home');


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


/*
/* JSON
*/
Route::get('/home/comercial/client/cnae/search','Client\CnaeController@search')->middleware('auth');
Route::get('/home/comercial/client/client/search','Client\ClientController@search')->middleware('auth');
Route::get('/helper/cep','Helper\HelperController@getAdressInformations')->middleware('auth');
Route::get('/helper/cnpj','Helper\HelperController@getCNPJInformations')->middleware('auth');
Route::get('/home/comercial/budget/service_type/search','Budget\ServiceTypeController@search')->middleware('auth');

/*
/* Acesso Routers
*/

//Acesso resources
Route::resource('home/acess/users','User\UserController')->middleware('auth');
Route::resource('home/acess/user-client','User\UserHasClientController')->middleware('auth');

//Acesso Menus
Route::get('/home/acess','AdmController@showAcess')->middleware('auth')->name('home.acess');
Route::get('/home/acess/user','AdmController@showUser')->middleware('auth')->name('acess.user');

//tables routes
Route::get('/home/acess/user/users','User\UserController@getUsers')->middleware('auth');

/*
/* Comercial Routers
*/

Route::get('orcamento','Budget\BudgetController@create')->name('orcamento.create');
Route::post('orcamento/store','Budget\BudgetController@store')->name('orcamento.store');

//Comercial Menus
Route::get('/home/comercial','AdmController@showComercial')->middleware('auth')->name('home.comercial');
Route::get('/home/comercial/budget','AdmController@showBudget')->middleware('auth')->name('comercial.budget');
Route::get('/home/comercial/client','AdmController@showClient')->middleware('auth')->name('comercial.client');

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
Route::get('/home/comercial/client/clients','Client\ClientController@getClients')->middleware('auth');
Route::get('/home/comercial/client/activitys','Client\ActivityController@getActivitys')->middleware('auth');
Route::get('/home/comercial/budget/areas','Budget\AreaController@getAreas')->middleware('auth');
Route::get('/home/comercial/budget/services','Budget\ServiceController@getServices')->middleware('auth');
Route::get('/home/comercial/budget/payments','Budget\PaymentController@getPayments')->middleware('auth');
Route::get('/home/comercial/budget/transports','Budget\TransportController@getTransports')->middleware('auth');
Route::get('/home/comercial/budget/budgets','Budget\BudgetController@getBudgets')->middleware('auth');



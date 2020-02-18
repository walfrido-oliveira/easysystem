<?php

use \App\Role\UserRole;
use App\Notifications\WelcomeUser;

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

Route::get('teste', function() {
    ini_set('max_execution_time', 3000000000000);

    $URL_BASE = "http://www.inmetro.gov.br/laboratorios/rbc/lista_laboratorios.asp?descr_ordem=&nom_servico=&descr_area_atuacao=&nom_laboratorio=&sig_uf=&ind_pagina=#&paginaIni=1&paginaFim=106";
    $ROOT = "http://www.inmetro.gov.br/laboratorios/rbc/";

    $MAX_PAGE = 106;

    $urls = [];
    $clients = [];
    $columnsNamesA = ["Acreditação Nº", "Data da Acreditação","ACREDITAÇÃO VIGENTE","Última Revisão do Escopo","Razão Social",
                     "Nome do Laboratório","Situação","Endereço","Bairro","CEP","Cidade","UF","Telefone",
                     "Fax","Grupo de Serviço de Calibração","Gerente Técnico","Email"];
    $columnsNamesB = ["Grupo de Serviço de Calibração","Gerente Técnico","Email"];

    for ($z=1; $z <= $MAX_PAGE; $z++) {
        $url_temp = str_replace("#", $z, $URL_BASE);

        $content = App\Helpers\AppHelper::instance()->url_get_contents($url_temp);

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);

        $dom->loadHTML($content);

        $xpath = new DOMXPath($dom);

        $dom_node_list = $xpath->query('//*[contains(@class,"listagem")]/a/@href');

        $temp_dom = new DomDocument();

        foreach ($dom_node_list as $value) {
            $posfix_url = substr($value->nodeValue, strrpos($value->nodeValue, "&area=") + 6);
            $prefix_url = substr($value->nodeValue,0, strrpos($value->nodeValue, "&area=") + 6);
            $result = $ROOT . $prefix_url . str_replace([' ','Ç','Ã','Í'],['%20','%C7','%C3','%CD'],$posfix_url);
            if (!in_array($result, $urls)) $urls[] = $result;
        }

    }

    foreach ($urls as $key => $value) {
        $content = App\Helpers\AppHelper::instance()->url_get_contents($value);

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);

        $dom->loadHTML($content);

        $xpath = new DOMXPath($dom);

        $rows = 14;
        $columns = 2;

        $array_temp = [];

        for ($i=1; $i <= 2; $i++) {
            for($y = 1; $y <= $columns; $y++) {
                for($a = 1; $a <= $rows; $a++) {
                    $query = '//body/table[3]/tr/td[2]/table/tr[2]/td[1]/table[%]/tr[#]/td[$]';
                    $dom_node_list = $xpath->query(str_replace("%", $i, str_replace("$", $y, str_replace("#", $a, $query))));

                    $temp_dom = new DomDocument();

                    foreach ($dom_node_list as $value) {
                        if($y == 2) {
                            if($i==1) $colum_name = $columnsNamesA[$a-1];
                            if($i==2) $colum_name = $columnsNamesB[$a-1];
                            $array_temp[$colum_name] = str_replace(["\t","\r","\n","  "], "", $value->nodeValue);
                        }
                    }
                }
            }
        }

        $clients[$key] = $array_temp;

    }

    return response()->json($clients);

});

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes(['register' => false, 'verify' => true]);
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
})->middleware(['auth'])->name('home');

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

//Route::get('orcamento','Budget\BudgetController@create')->name('orcamento.create');
//Route::post('orcamento/store','Budget\BudgetController@store')->name('orcamento.store');

/*
/* Comercial Menus
*/
Route::get('/home/comercial','AdmController@showComercial')->middleware('auth')->name('home.comercial');
Route::get('/home/comercial/budget','AdmController@showBudget')->middleware('auth')->name('comercial.budget');
Route::get('/home/comercial/client','AdmController@showClient')->middleware('auth')->name('comercial.client');

/*
/* Comercial Resources
*/
Route::resource('/home/comercial/budget/budget','Budget\BudgetController')->middleware('auth');
Route::resource('/home/comercial/budget/budget-files','Budget\BudgetFilesController')->middleware('auth');
Route::resource('/home/comercial/budget/area','Budget\AreaController')->middleware('auth');
Route::resource('/home/comercial/budget/service','Budget\ServiceController')->middleware('auth');
Route::resource('/home/comercial/budget/payment','Budget\PaymentController')->middleware('auth');
Route::resource('/home/comercial/budget/transport','Budget\TransportController')->middleware('auth');
Route::resource('/home/comercial/client/client','Client\ClientController')->middleware('auth');
Route::resource('/home/comercial/client/activity','Client\ActivityController')->middleware('auth');

/*
/* Tables Ajax
*/
Route::get('/home/comercial/client/clients','Client\ClientController@getClients')->middleware('auth');
Route::get('/home/comercial/client/activitys','Client\ActivityController@getActivitys')->middleware('auth');
Route::get('/home/comercial/budget/areas','Budget\AreaController@getAreas')->middleware('auth');
Route::get('/home/comercial/budget/services','Budget\ServiceController@getServices')->middleware('auth');
Route::get('/home/comercial/budget/payments','Budget\PaymentController@getPayments')->middleware('auth');
Route::get('/home/comercial/budget/transports','Budget\TransportController@getTransports')->middleware('auth');
Route::get('/home/comercial/budget/budgets','Budget\BudgetController@getBudgets')->middleware('auth');


/*
/* Files
*/
Route::get('/pdf/signer','SignerController@signer')->middleware('auth')->name('pdf.signer');
Route::get('/open/{id}', 'OpenFileController@index')->middleware('auth')->name('file.open');
Route::get('/download/{id}', 'DownloadFileController@index')->middleware('auth')->name('file.download');
Route::post('/budget/upload', 'Budget\BudgetFilesController@upload')->middleware('auth')->name('budget.upload');

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
/* User Routers
*/
Route::get('/home/user/budget','User\BudgetController@index')->middleware('auth')->name('user.budget.index');
Route::get('/home/user/budget/show/{id}','User\BudgetController@show')->middleware('auth')->name('user.budget.show');
Route::get('/home/user/budget/budgets','User\BudgetController@getBudgets')->middleware('auth')->name('user.budget.budgets');

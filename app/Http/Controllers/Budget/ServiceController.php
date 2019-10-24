<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use App\Budget\Area;
use App\Budget\Taxation;
use App\Budget\ServiceCategory;
use App\Budget\ServiceCategoryType;
use DB;

class ServiceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('active',1)->paginate(10);

        return view('adm.comercial.budget.service.index',compact('services'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::where('active',1)->get();

        $types = $this->getTypeEnum('type');

        $locals = $this->getTypeEnum('local');

        $taxations = Taxation::where('active',1)->get();

        $categorys = ServiceCategory::where('active',1)->orderBy('service_category_type_id')->get();

        $categoryTypes = ServiceCategoryType::where('active',1)->get();

        return view('adm.comercial.budget.service.create',
                compact('areas','types','locals','taxations','categorys','categoryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->mesagens());

        $data = $this->cleanData($request->all());

        Service::create($data);

        return redirect()->route('service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('adm.comercial.budget.service.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $areas = Area::where('active',1)->get();

        $types = $this->getTypeEnum('type');

        $locals = $this->getTypeEnum('local');

        $taxations = Taxation::where('active',1)->get();

        $categorys = ServiceCategory::where('active',1)->orderBy('service_category_type_id')->get();

        $categoryTypes = ServiceCategoryType::where('active',1)->get();

        return view('adm.comercial.budget.service.edit',
                compact('service','areas','types','locals','taxations',
                        'categorys','categoryTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate($this->rules(), $this->mesagens());

        $data = $this->cleanData($request->all());

        $service->update($data);

        return redirect()->route('service.index')
                        ->with('success','Serviço adicionado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
                        ->with('success','Serviço deletado com sucesso');
    }

    /**
     * Retrieves enum fields
     *
     * @return array
     */
    public function getTypeEnum($column)
    {
        $instance = new Service();

        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$column.'"'))[0]->Type;

        preg_match_all("/'([^']+)'/", $enumStr, $matches);

        return isset($matches[1]) ? $matches[1] : [];

    }

    /**
     * Remove caracters
     *
     * @return array
     */
    private function cleanData($data)
    {
        $data['value'] = str_replace('.','',$data['value'] );
        $data['value'] = str_replace(',','.',$data['value'] );

        $data['iss_aliquot'] = str_replace('.','',$data['iss_aliquot'] );
        $data['iss_aliquot'] = str_replace(',','.',$data['iss_aliquot'] );

        $data['pis_aliquot'] = str_replace('.','',$data['pis_aliquot'] );
        $data['pis_aliquot'] = str_replace(',','.',$data['pis_aliquot'] );

        $data['confins_aliquot'] = str_replace('.','',$data['confins_aliquot'] );
        $data['confins_aliquot'] = str_replace(',','.',$data['confins_aliquot'] );

        $data['csll_aliquot'] = str_replace('.','',$data['csll_aliquot'] );
        $data['csll_aliquot'] = str_replace(',','.',$data['csll_aliquot'] );

        $data['ir_aliquot'] = str_replace('.','',$data['ir_aliquot'] );
        $data['ir_aliquot'] = str_replace(',','.',$data['ir_aliquot'] );

        $data['inss_aliquot'] = str_replace('.','',$data['inss_aliquot'] );
        $data['inss_aliquot'] = str_replace(',','.',$data['inss_aliquot'] );

        $data['inss_decrease'] = str_replace('.','',$data['inss_decrease'] );
        $data['inss_decrease'] = str_replace(',','.',$data['inss_decrease'] );

        return $data;
    }

    /**
     * Set rules validation
     *
     * @return array
     */
    private function rules()
    {
        return array(
            'desc' => 'required|max:255',
            'area_id' => 'required',
            'type' => 'required|max:255',
            'local' => 'required|max:255',
            'value' => 'required|regex:/^\d+(\,\d{1,2})?$/',
            'range' => 'required',
        );
    }

    /**
     * Set mesagens validation
     *
     * @return array
     */
    private function mesagens()
    {
        return array(
            'desc.required' => 'O campo descrição é obrigatório',
            'area_id.required' => 'O campo área é obrigatório',
            'type' => 'O campo tipo é obrigatório',
            'local.required' => 'O campo local é obrigatório',
            'value.required' => 'O campo valor é obrigatório',
            'value.regex' => 'O campo valor deve ser um número',
            'range.required' => 'O campo faixa é obrigatório',
        );
    }
}

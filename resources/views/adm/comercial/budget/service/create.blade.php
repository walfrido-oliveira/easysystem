@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.service.header')
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ops!</strong> Há problemas com os campos.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('service.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="desc" class="col-sm-2 col-form-label">Descrição: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="desc" id="desc" placeholder="Descrição" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="local" class="col-sm-2 col-form-label">Tributação dos Serviços:</label>
                                    <div class="col-sm-5">
                                        <select  class="form-control custom-select" name="taxation_id" id="taxation_id">
                                            <option disabled selected value> -- selecione uma opção -- </option>
                                            @foreach ($taxations as $taxation)
                                                <option value="{{ $taxation->id }}">{{ $taxation->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="cm" class="col-sm-2 col-form-label">Código do Serviço Municipal: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cm" id="value" placeholder="Código do Serviço Municipal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="service_type_id" class="col-sm-2 col-form-label">Código do Serviço LC 116:</label>
                                    <div class="col-sm-4 pr-0">
                                        <input type="text" class="form-control" name="service_type_id" id="service_type_id"
                                            placeholder="Código do Serviço">
                                    </div>
                                    <div class="pl-0 col-sm-1">
                                        <label class="custom-file-upload">
                                            <input type="button"  name="search_service_type" id="search_service_type">
                                            <i class="fa fa-search"></i>
                                        </label>
                                    </div>
                                    <label for="nbs" class="col-sm-2 col-form-label">Código NBS:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="nbs" id="nbs"
                                            placeholder="Código NBS - Nomenclatura Brasileira de Serviços">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="service_category_id" class="col-sm-2 col-form-label">Categoria:</label>
                                    <div class="col-sm-5">
                                        <select  class="form-control custom-select" name="service_category_id" id="service_category_id">
                                            <option disabled selected value> -- selecione uma opção -- </option>
                                            @foreach ($categoryTypes as $type)
                                                <optgroup label="{{ $type->name }}">
                                                @foreach ($categorys as $category)
                                                    @if($category->service_category_type_id == $type->id)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="value" class="col-sm-2 col-form-label">Preço Unitário: </label>
                                    <div class="col-sm-3">
                                        <mask-money-component :name="'value'" :id="'value'"
                                            :placeholder="'Valor'" :precision="2"></mask-money-component>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="serviceTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="fin-tab" data-toggle="tab" href="#fin-fields" role="tab" aria-controls="fin-fields"
                                    aria-selected="true">Impostos e Rentenções</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="lab-tab" data-toggle="tab" href="#lab-fields" role="tab" aria-controls="lab-fields"
                                    aria-selected="true">Laboratório</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="fin-fields" role="tabpanel" aria-labelledby="fin-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="iss_aliquot" class="col-sm-2 col-form-label">% Alíquota do ISS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'iss_aliquot'" :id="'iss_aliquot'"
                                                    :placeholder="'Alíquota do ISS'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox col-sm-2">
                                                <input class="custom-control-input" type="checkbox" id="iss_withheld" name="iss_withheld" >
                                                <label class="custom-control-label" for="iss_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                            <label for="pis_aliquot" class="col-sm-2 col-form-label">% Alíquota do PIS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'pis_aliquot'" :id="'pis_aliquot'"
                                                    :placeholder="'Alíquota do PIS'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="pis_withheld"
                                                    name="pis_withheld" >
                                                <label class="custom-control-label" for="pis_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="confins_aliquot" class="col-sm-2 col-form-label">% Alíquota do COFINS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'confins_aliquot'" :id="'confins_aliquot'"
                                                    :placeholder="'Alíquota do CONFINS'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox col-sm-2">
                                                <input class="custom-control-input" type="checkbox" id="confins_withheld"
                                                name="confins_withheld">
                                                <label class="custom-control-label" for="confins_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                            <label for="csll_aliquot" class="col-sm-2 col-form-label">% Alíquota do COFINS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'csll_aliquot'" :id="'csll_aliquot'"
                                                    :placeholder="'Alíquota do CONFINS'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="csll_withheld"
                                                name="csll_withheld">
                                                <label class="custom-control-label" for="csll_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="ir_aliquot" class="col-sm-2 col-form-label">% Alíquota do IR:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'ir_aliquot'" :id="'ir_aliquot'"
                                                    :placeholder="'Alíquota do IR'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox col-sm-2">
                                                <input class="custom-control-input" type="checkbox" id="ir_withheld"
                                                name="ir_withheld" >
                                                <label class="custom-control-label" for="ir_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                            <label for="inss_aliquot" class="col-sm-2 col-form-label">% Alíquota do INSS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'inss_aliquot'" :id="'inss_aliquot'"
                                                    :placeholder="'Alíquota do INSS'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="inss_withheld"
                                                name="inss_withheld" >
                                                <label class="custom-control-label" for="inss_withheld" >
                                                    Retido?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="inss_decrease" class="col-sm-2 col-form-label">% Redução Base Cálc. INSS:</label>
                                            <div class="col-sm-2">
                                                <mask-money-component :name="'inss_decrease'" :id="'inss_decrease'"
                                                    :placeholder="'Alíquota do IR'" :precision="4" :max="99999" :min="0"></mask-money-component>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="lab-fields" role="tabpanel" aria-labelledby="lab-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="area_id" class="col-sm-1 col-form-label">Área: </label>
                                            <div class="col-sm-6">
                                                <select  class="form-control custom-select" name="area_id" id="area_id">
                                                    <option disabled selected value> -- selecione uma opção -- </option>
                                                    @foreach ($areas as $area)
                                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="type" class="col-sm-1 col-form-label">Tipo: </label>
                                            <div class="col-sm-3">
                                                <select  class="form-control custom-select" name="type" id="type">
                                                    <option disabled selected value> -- selecione uma opção -- </option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="local" class="col-sm-1 col-form-label">Local: </label>
                                            <div class="col-sm-3">
                                                <select  class="form-control custom-select" name="local" id="local">
                                                    <option disabled selected value> -- selecione uma opção -- </option>
                                                    @foreach ($locals as $local)
                                                        <option value="{{ $local }}">{{ $local }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="range" class="col-sm-1 col-form-label">Faixa: </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="range" id="range" placeholder="Faixa"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pt-3 border-top">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('service.index') }}" class="btn btn-success">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.typeservicemodal')

@endsection

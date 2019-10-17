@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.client.client.header')
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
                    <form action="{{ route('client.update',$client->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <img src="{{URL::asset( 'storage/app/' . $client->logo )}}" alt="Logo" width="64" height="64" id="output_logo">
                                    <label  class="custom-file-upload">
                                        <input type="file" accept="image/x-png,image/jpeg" name="logo" id="logo" />
                                        <i class="fa fa-cloud-upload"></i>Alterar
                                    </label>
                                    <small class="form-text text-muted">Tamanho máximo permitido: 50kb.</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="razao_social" class="col-sm-2 col-form-label">Razão Social: </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="razao_social" id="razao_social" placeholder="Razão Social" required value="{{ $client->razao_social }}">
                                    </div>
                                    <label for="cnpj" class="col-sm-1 col-form-label">CNPJ: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{ $client->cnpj }}" data-mask="99.999.999/9999-99" selectonfocus="true" clearifnotmatch="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="nome_fantasia" class="col-sm-2 col-form-label">Nome Fantasia: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" placeholder="Nome Fantasia" required value ="{{ $client->nome_fantasia }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="ddd" class="col-sm-2 col-form-label">DDD: </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="ddd" id="ddd" placeholder="DDD" value="{{ $client->ddd }}">
                                    </div>
                                    <label for="phone" class="col-sm-1 col-form-label">Telefone:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control phone" name="phone" id="phone" placeholder="Telefone" value="{{ $client->phone }}">
                                    </div>
                                    <label for="contact" class="col-sm-1 col-form-label">Contato:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="contact" id="contact" placeholder="Contato" value="{{ $client->contact }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="clientTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="adress-tab" data-toggle="tab" href="#adress-fields" role="tab" aria-controls="adress-fields"
                                aria-selected="true">Endereço</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts"
                                aria-selected="true">Contato</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="others-tab" data-toggle="tab" href="#others" role="tab" aria-controls="others"
                                aria-selected="false">Inscrições, CNAE e outros</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="adress-fields" role="tabpanel" aria-labelledby="adress-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="adress" class="col-sm-2 col-form-label">Endereço: </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="adress" id="adress" placeholder="Endereço" value="{{ $client->adress }}">
                                            </div>
                                            <label for="number" class="col-sm-1 col-form-label">Número: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="number" id="number" placeholder="Número" value="{{ $client->number }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="district" class="col-sm-2 col-form-label">Bairro: </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="district" id="district" placeholder="Bairro" value="{{ $client->district }}">
                                            </div>
                                            <label for="complement" class="col-sm-1 col-form-label">Compl.: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="complement" id="complement" placeholder="Complemento" value="{{ $client->complement }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="state" class="col-sm-2 col-form-label">UF: </label>
                                            <div class="col-sm-2">
                                                <select  class="form-control custom-select" name="state" id="state" >
                                                    @foreach ($ufs as $uf)
                                                        <option value="{{ $uf->uf }}">{{ $uf->uf . ' - ' . $uf->name }}</option>
                                                        @if ($uf->uf == $client->state)
                                                            <option value="{{ $uf->uf }}" selected>{{ $uf->uf . ' - ' . $uf->name }}</option>
                                                        @else
                                                            <option value="{{ $uf->uf }}">{{ $uf->uf . ' - ' . $uf->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="city" class="col-sm-1 col-form-label">Cidade: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="city" id="city" placeholder="Cidade" value="{{ $client->city }}">
                                            </div>
                                            <label for="cep" class="col-sm-1 col-form-label">CEP: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="cep" id="cep" value="{{ $client->cep }}" data-mask="99999-999" selectonfocus="true" clearifnotmatch="true">
                                                <small class="form-text text-muted" id="loading-cep"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                         <div class="form-group row">
                                            <label for="ddd_2" class="col-sm-1 col-form-label">DDD: </label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="ddd_2" id="ddd_2" placeholder="DDD 2" value="{{ $client->ddd_2 }}">
                                            </div>
                                            <label for="phone_2" class="col-sm-1 col-form-label">Telefone:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control phone" name="phone_2" id="phone_2" placeholder="Telefone 2" value="{{ $client->phone_2 }}">
                                            </div>
                                            <label for="mail" class="col-sm-1 col-form-label">Email: </label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="mail" id="ddd_2" placeholder="Email" value="{{ $client->mail }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                         <div class="form-group row">
                                            <label for="website" class="col-sm-1 col-form-label">Site:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="website" id="website" placeholder="Site" value="{{ $client->website }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                         <div class="form-group row">
                                            <label for="ie" class="col-sm-2 col-form-label">IE: </label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="ie" id="ie" placeholder="Inscrição Estadual" value="{{ $client->ie }}">
                                            </div>
                                            <label for="im" class="col-sm-1 col-form-label">IM:</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="im" id="im" placeholder="Inscrição Municipal" value="{{ $client->im }}">
                                            </div>
                                            <label for="suframa" class="col-sm-2 col-form-label">SUFRAMA:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="suframa" id="suframa" placeholder="Inscrição SUFRAMA" value="{{ $client->suframa }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="id_type_client_activity" class="col-sm-2 col-form-label">Atividade: </label>
                                            <div class="col-sm-5">
                                                <select  class="form-control custom-select" name="id_type_client_activity" id="id_type_client_activity" required>
                                                    @foreach ($activitys as $activity)
                                                        @if ($client->id_type_client_activity == $activity->id)
                                                            <option value="{{ $activity->id }}" selected>{{ $activity->name }}</option>
                                                        @else
                                                            <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="cnae" class="col-sm-1 col-form-label">CNAE:</label>
                                            <div class="col-sm-2 pr-0">
                                                <input type="text" class="form-control" name="cnae" id="cnae" placeholder="CNAE Principal" value="{{ $client->cnae }}" >
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <label class="custom-file-upload">
                                                    <input type="button"  name="search_cnae" id="search_cnae">
                                                    <i class="fa fa-search"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <div class="col-sm-2">Simples Nacional?</div>
                                            <div class="col-sm-10">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="simples_nacional" name="simples_nacional" {{ $client->simples_nacional }}>
                                                <label class="custom-control-label" for="simples_nacional" >
                                                Sim
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">Produtor Rural?</div>
                                            <div class="col-sm-10">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="produtor_rural" name="produtor_rural" {{ $client->produtor_rural }}>
                                                <label class="custom-control-label" for="produtor_rural">
                                                Sim
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 border-top p-5">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="obs" class="col-sm-2 col-form-label">Observações:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="obs" id="obs" placeholder="Observações">{{ $client->obs }}</textarea>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group border-top">
                            <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('adm.comercial.client.client.cnaemodal')

@endsection



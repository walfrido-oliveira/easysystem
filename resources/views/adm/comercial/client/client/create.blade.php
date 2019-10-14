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
                    <form action="{{ route('client.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <img src="{{URL::asset('/img/icons/picture.png')}}" alt="Logo" width="64" height="64" id="output_logo">
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
                                        <input type="text" class="form-control" name="razao_social" id="razao_social" placeholder="Razão Social" required>
                                    </div>
                                    <label for="cnpj" class="col-sm-1 col-form-label">CNPJ: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="nome_fantasia" class="col-sm-2 col-form-label">Nome Fantasia: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" placeholder="Nome Fantasia" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="clientTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="adress-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                                aria-selected="true">Endereço</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                                aria-selected="false">Contato</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="others-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                                aria-selected="false">Inscrições, CNAE e outros</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="adress-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="adress" class="col-sm-2 col-form-label">Endereço: </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="adress" id="adress" placeholder="Endereço" >
                                            </div>
                                            <label for="number" class="col-sm-1 col-form-label">Número: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="number" id="number" placeholder="Número" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="district" class="col-sm-2 col-form-label">Bairro: </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="district" id="district" placeholder="Bairro" >
                                            </div>
                                            <label for="complement" class="col-sm-1 col-form-label">Compl.: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="complement" id="complement" placeholder="Complemento" >
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
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="city" class="col-sm-1 col-form-label">Cidade: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="city" id="city" placeholder="Cidade" >
                                            </div>
                                            <label for="cep" class="col-sm-1 col-form-label">CEP: </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP">
                                                <small class="form-text text-muted" id="loading-cep"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="contact-tab">

                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="others-tab">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="id_type_client_activity" class="col-sm-2 col-form-label">Atividade: </label>
                                            <div class="col-sm-6">
                                                <select  class="form-control custom-select" name="id_type_client_activity" id="id_type_client_activity" required>
                                                    @foreach ($activitys as $activity)
                                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
@endsection

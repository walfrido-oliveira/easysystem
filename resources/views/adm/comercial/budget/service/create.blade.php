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
                                    <label for="desc" class="col-sm-1 col-form-label">Des.: </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="desc" id="desc" placeholder="Descrição" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="area_id" class="col-sm-1 col-form-label">Área: </label>
                                    <div class="col-sm-6">
                                        <select  class="form-control custom-select" name="area_id" id="area_id" required>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <label for="type" class="col-sm-1 col-form-label">Tipo: </label>
                                    <div class="col-sm-3">
                                        <select  class="form-control custom-select" name="type" id="type" required>
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
                                        <select  class="form-control custom-select" name="local" id="local" required>
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
                                        <textarea class="form-control" name="range" id="range" placeholder="Faixa" required>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="value" class="col-sm-1 col-form-label">Valor: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="value" id="value" placeholder="Valor"
                                        data-mask="#.##0,00" selectonfocus="true" clearifnotmatch="true" data-mask-reverse="true">
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
@endsection

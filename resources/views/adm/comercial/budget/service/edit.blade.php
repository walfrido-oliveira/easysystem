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
                    <form action="{{ route('service.update',$service->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="desc" class="col-sm-1 col-form-label">Des.: </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="desc" id="desc"  required>{{ $service->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="area_id" class="col-sm-1 col-form-label">Área: </label>
                                    <div class="col-sm-10">
                                        <select  class="form-control custom-select" name="area_id" id="area_id" required>
                                        @foreach ($areas as $area)
                                            @if ($area->id == $service->area_id)
                                                <option value="{{ $area->id }}" selected>{{ $area->name }}</option>
                                            @else
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="type" class="col-sm-1 col-form-label">Tipo: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="type" id="type" placeholder="Tipo" required value="{{ $service->type }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="local" class="col-sm-1 col-form-label">Local: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="local" id="local" placeholder="Local" required value="{{ $service->local }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="range" class="col-sm-1 col-form-label">Faixa: </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="range" id="range" placeholder="Faixa" required >{{ $service->range }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="value" class="col-sm-1 col-form-label">Valor: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="value" id="value" placeholder="Valor" required value="{{ $service->value }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

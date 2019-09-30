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
                                <div class="form-group">
                                    <label for="desc" class="col-sm-2 col-form-label">Descrição: </label>
                                    <textarea class="from-control col-sm-9" name="desc" id="desc" placeholder="Descrição" required>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="id_sgv" class="col-sm-2 col-form-label">SGV (ID): </label>
                                    <input type="text" class="from-control" name="id_sgv" id="id_sgv" placeholder="SGV (ID)" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="area_id" class="col-sm-2 col-form-label">Área: </label>
                                    <select  class="form-control col-sm-9 custom-select" name="area_id" id="area_id" required>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 col-form-label">Tipo: </label>
                                    <input type="text" class="from-control" name="type" id="type" placeholder="Tipo" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="local" class="col-sm-2 col-form-label">Local: </label>
                                    <input type="text" class="from-control" name="local" id="local" placeholder="Local" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="value" class="col-sm-2 col-form-label">Valor: </label>
                                    <input type="text" class="from-control" name="value" id="value" placeholder="Valor" required>
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

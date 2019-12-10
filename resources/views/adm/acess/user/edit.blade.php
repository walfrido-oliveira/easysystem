@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.acess.user.header')
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
                    <form action="{{ route('users.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-1 col-form-label">{{ __('Nome: ') }}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Nome" readonly>
                                    </div>
                                    <label for="email" class="col-sm-2 col-form-label">{{ __('Email: ') }}</label>
                                    <div class="col-sm-4">
                                        <input id="email" type="email" class="form-control"
                                        name="email" value="{{ $user->email }}" required autocomplete="email" placeholder="Email" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="type" class="col-sm-1 col-form-label">{{ __('Tipo: ') }}</label>
                                    <div class="col-sm-4">
                                        <select  class="form-control custom-select" name="type" id="type" >
                                            <option value="adm" {{ $user->type == "user" ? 'selected' : '' }}>Administrador</option>
                                            <option value="user" {{ $user->type == "user" ? 'selected' : '' }}>Cliente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-1">{{ __('Status: ') }}</div>
                                        <div class="col-sm-10">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="active_checkbox" name="active_checkbox"
                                                {{ $user->active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="active_checkbox">
                                                {{ __('Ativo') }}
                                                </label>
                                                <input type="hidden" value="1" name="active" id='active'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pt-3 border-top">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('users.index') }}" class="btn btn-success">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

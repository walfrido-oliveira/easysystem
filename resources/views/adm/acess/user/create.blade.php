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
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-1 col-form-label">{{ __('Nome: ') }}</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="name" placeholder="Nome">
                                    </div>
                                    <label for="email" class="col-sm-2 col-form-label">{{ __('Email: ') }}</label>
                                    <div class="col-sm-4">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="password" class="col-sm-1 col-form-label">{{ __('Senha: ') }}</label>
                                    <div class="col-sm-5">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password" placeholder="Senha">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="password" class="col-sm-2 col-form-label">{{ __('Confirmar Senha:') }}</label>
                                    <div class="col-sm-4">
                                        <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Senha">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="type" class="col-sm-1 col-form-label">{{ __('Tipo: ') }}</label>
                                    <div class="col-sm-5">
                                        <select  class="form-control custom-select" name="type" id="type" >
                                            <option value="adm">Administrador</option>
                                            <option value="user">Cliente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-1">{{ __('Status: ') }}</div>
                                        <div class="col-sm-10">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="active_checkbox" name="active_checkbox" checked>
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
                            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-success">{{ __('Voltar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel de Controle Administrativo</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('home.comercial') }}" class="link-light">Comercial</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('comercial.budget') }}" class="link-light">Orçamento</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('client.index') }}">
                                    <img src="{{URL::asset('/img/icons/client.png')}}" alt="Áreas">
                                </a>
                                <div class="title">Clientes</div>
                            </li>
                            <li>
                                <a href="{{ route('activity.index') }}">
                                    <img src="{{URL::asset('/img/icons/add.png')}}" alt="Transporte">
                                </a>
                                <div class="title">Atividade</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

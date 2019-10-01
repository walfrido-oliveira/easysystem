@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel de Controle Administrativo</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('home.comercial') }}">
                                    <img src="{{URL::asset('/img/icons/value.png')}}" alt="Comercial">
                                </a>
                                <div class="title">Comercial</div>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{URL::asset('/img/icons/padlock.png')}}" alt="Acessos">
                                </a>
                                <div class="title">Acesso</div>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{URL::asset('/img/icons/service.png')}}" alt="Serviços">
                                </a>
                                <div class="title">Serviços</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

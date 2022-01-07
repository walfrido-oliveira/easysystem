@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel de Controle Administrativo</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('home.comercial') }}" class="link-light">Comercial</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('comercial.budget') }}">
                                    <img src="{{URL::asset('/img/icons/docs.png')}}" alt="Documentos">
                                </a>
                                <div class="title">Documentos</div>
                            </li>
                            <li>
                                <a href="{{ route('comercial.client') }}">
                                    <img src="{{URL::asset('/img/icons/client.png')}}" alt="Cliente">
                                </a>
                                <div class="title">Cliente</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

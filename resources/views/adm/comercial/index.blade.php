@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel de Controle Administrativo</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('home_comercial') }}" class="link-light">Comercial</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('comercial_budget') }}">
                                    <img src="{{URL::asset('/img/icons/budget.png')}}" alt="Orçamento">
                                </a>
                                <div class="title">Orçamento</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

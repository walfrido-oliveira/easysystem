@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel de Controle Administrativo</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('home_comercial') }}" class="link-light">Comercial</a> <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('comercial_budget') }}" class="link-light">Orçamento</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('area.index') }}">
                                    <img src="{{URL::asset('/img/icons/add.png')}}" alt="Áreas">
                                </a>
                                <div class="title">Áreas</div>
                            </li>
                            <li>
                                <a href="">
                                    <img src="{{URL::asset('/img/icons/trucking.png')}}" alt="Transporte">
                                </a>
                                <div class="title">Transporte</div>
                            </li>
                            <li>
                                <a href="">
                                    <img src="{{URL::asset('/img/icons/payment.png')}}" alt="Pagamento">
                                </a>
                                <div class="title">Pagamento</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                            @if (config('app.modules.comercial.budget.budget.visible'))
                                <li>
                                    <a href="{{ route('budget.index') }}">
                                        <img src="{{URL::asset('/img/icons/budget.png')}}" alt="Serviços">
                                    </a>
                                    <div class="title">Orçamentos</div>
                                </li>
                            @endif
                            @if (config('app.modules.comercial.budget.transport.visible'))
                                <li>
                                    <a href="{{ route('transport.index') }}">
                                        <img src="{{URL::asset('/img/icons/trucking.png')}}" alt="Transporte">
                                    </a>
                                    <div class="title">Transporte</div>
                                </li>
                            @endif
                            @if (config('app.modules.comercial.budget.payment.visible'))
                                <li>
                                    <a href="{{ route('payment.index') }}">
                                        <img src="{{URL::asset('/img/icons/payment.png')}}" alt="Pagamento">
                                    </a>
                                    <div class="title">Pagamento</div>
                                </li>
                            @endif
                            @if (config('app.modules.comercial.budget.area.visible'))
                                <li>
                                    <a href="{{ route('area.index') }}">
                                        <img src="{{URL::asset('/img/icons/add.png')}}" alt="Áreas">
                                    </a>
                                    <div class="title">Áreas</div>
                                </li>
                            @endif
                            @if (config('app.modules.comercial.budget.service.visible'))
                                <li>
                                    <a href="{{ route('service.index') }}">
                                        <img src="{{URL::asset('/img/icons/service.png')}}" alt="Serviços">
                                    </a>
                                    <div class="title">Serviços</div>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('home') }}" class="link-light">Painel do Cliente</a>
                </div>

                <div class="card-body">
                    <nav class="row align-items-center justify-content-center">
                        <ul class="thumb">
                            <li>
                                <a href="{{ route('user.budget.index') }}">
                                    <img src="{{URL::asset('/img/icons/service.png')}}" alt="Comercial">
                                </a>
                                <div class="title">Orçamentos</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

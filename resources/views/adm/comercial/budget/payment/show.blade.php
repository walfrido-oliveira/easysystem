@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.payment.header')
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $payment->id }}
                    </div>
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $payment->name }}
                    </div>
                    <div class="form-group">
                        <a href="{{ route('payment.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

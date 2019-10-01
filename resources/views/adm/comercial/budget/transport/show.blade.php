@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.transport.header')
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $transport->id }}
                    </div>
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $transport->name }}
                    </div>
                    <div class="form-group">
                        <a href="{{ route('transport.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

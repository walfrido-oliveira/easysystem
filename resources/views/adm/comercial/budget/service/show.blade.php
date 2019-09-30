@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.service.header')
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $service->id }}
                    </div>
                    <div class="form-group">
                        <strong>Descrição:</strong>
                        {{ $service->desc }}
                    </div>
                    <div class="form-group">
                        <strong>Área:</strong>
                        {{ $service->area->name }}
                    </div>
                    <div class="form-group">
                        <strong>Tipo:</strong>
                        {{ $service->type }}
                    </div>
                    <div class="form-group">
                        <strong>Local:</strong>
                        {{ $service->local }}
                    </div>
                    <div class="form-group">
                        <strong>Valor:</strong>
                        {{ __('R$ ') . $service->value }}
                    </div>
                    <div class="form-group">
                        <strong>Ativo:</strong>
                        @if ($service->active)
                            {{ __('ATIVO') }}
                        @else
                        {{ __('INATIVO') }}
                        @endif
                    </div>
                    <div class="form-group">
                        <a href="{{ route('service.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

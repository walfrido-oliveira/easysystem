@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Painel de Controle Administrativo -> Comercial -> Orçamento -> Áreas -> Visualizar</div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $area->id }}
                    </div>
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $area->name }}
                    </div>
                    <div class="form-group">
                        <a href="{{ route('area.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

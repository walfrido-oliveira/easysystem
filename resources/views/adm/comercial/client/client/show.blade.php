@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.client.activity.header')
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $activity->id }}
                    </div>
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $activity->name }}
                    </div>
                    <div class="form-group">
                        <a href="{{ route('activity.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

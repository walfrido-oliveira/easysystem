@extends('layouts.app')

@section('content')
{{ $i = 0 }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.budget.header')
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <strong>ID:</strong>
                        {{ $budget->id }}
                    </div>
                    <div class="form-group">
                        <strong>Contato:</strong>
                        {{ $budget->contact }}
                    </div>
                    <div class="form-group">
                        <strong>Empresa:</strong>
                        {{ $budget->client }}
                    </div>
                    <div class="form-group">
                        <strong>CNPJ / CPF:</strong>
                        {{ $budget->client_id }}
                    </div>
                    <div class="form-group">
                        <strong>Telefone:</strong>
                        {{ $budget->phone }}
                    </div>
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $budget->mail }}
                    </div>
                    <div class="form-group">
                        <strong>Forma de Pagamento:</strong>
                        {{ $budget->payment->name }}
                    </div>
                    <div class="form-group">
                        <strong>Forma de Transporte:</strong>
                        {{ $budget->transport->name }}
                    </div>
                    <div class="form-group">
                        <strong>Observações:</strong>
                        {{ $budget->obs }}
                    </div>

                    <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Qtd</th>
                        <th>Descrição</th>
                        <th>Área</th>
                        <th>Tipo</th>
                        <th>Local</th>
                        <th>Faixa</th>
                        <th>Observações</th>
                    </tr>

                    @foreach ($budget->services as $service)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $service->count }}</td>
                        <td>{{ $service->service->desc }}</td>
                        <td>{{ $service->service->area->name }}</td>
                        <td>{{ $service->service->type }}</td>
                        <td>{{ $service->service->local }}</td>
                        <td>{{ $service->service->range }}</td>
                        <td>{{ $service->obs }}</td>
                    </tr>
                    @endforeach
                    </table>

                    <div class="form-group">
                        <a href="{{ route('budget.index') }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

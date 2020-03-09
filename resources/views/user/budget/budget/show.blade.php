@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('user.budget.budget.header')
                </div>

                <div class="card-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="client_id" class="col-sm-1 col-form-label">Número:</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="internal_id" id="internal_id" class="form-control"
                                        placeholder="Número de Orçmento" readonly value="{{ $budget->internal_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="cnpj" class="col-sm-1 col-form-label">Cliente:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="client" id="client" placeholder="Cliente"
                                        readonly value="{{ !is_null($budget->client) ? $budget->client->razao_social : '' }}">
                                    </div>
                                    <label for="client_id" class="col-sm-1 col-form-label">CNPJ:</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ/CPF"
                                        readonly
                                        value="{{ !is_null($budget->client) ? vsprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', str_split($budget->client->cnpj)) : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="contact" class="col-sm-1 col-form-label">Contato: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="contact" id="contact" readonly value="{{ $budget->contact }}">
                                    </div>
                                    <label for="phone" class="col-sm-1 col-form-label">Telefone: </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="phone" id="phone" class="form-control" readonly value="{{ $budget->phone }}">
                                    </div>
                                    <label for="mail" class="col-sm-1 col-form-label">Email: </label>
                                    <div class="col-sm-3">
                                        <input type="mail" name="mail" id="mail" class="form-control" readonly value="{{ $budget->mail }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="payment_id" class="col-sm-1 col-form-label">Pagamento:</label>
                                    <div class="col-sm-5">
                                        <input type="mail" name="payment_id" id="payment_id" class="form-control" readonly value="{{ $budget->payment->name }}">
                                    </div>
                                    <label for="transport_id" class="col-sm-1 col-form-label">Transporte: </label>
                                    <div class="col-sm-5">
                                        <input type="mail" name="transport_id" id="transport_id" class="form-control" readonly value="{{ $budget->transport->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="obs" class="col-sm-1 col-form-label">Obs.: </label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control" name="obs" id="obs"  readonly>{{ $budget->obs }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm table-hover" id="files_table">
                                            <thead>
                                                <tr>
                                                    <th>Arquivo</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($files as $file)
                                                    <tr>
                                                        <td>{{ $file->name }}</td>
                                                        <td>
                                                            <a href="{{ route('file.open', $file->id) }}" class="btn btn-success"
                                                            target="_blank">
                                                                <i class="fa fa-folder-open"></i>
                                                            </a>
                                                            <a href="{{ route('file.download', $file->id) }}" class="btn btn-success"
                                                            target="_blank">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pt-3 border-top">
                            <a href="{{ route('user.budget.index') }}" class="btn btn-success">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.clientmodal')
@endsection

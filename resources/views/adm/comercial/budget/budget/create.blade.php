@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @include('adm.comercial.budget.budget.header')
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Ops!</strong> Há problemas com os campos.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('budget.store') }}" id="budget" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="client_id" class="col-sm-1 col-form-label">Número:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="internal_id" id="internal_id" class="form-control"
                                            placeholder="Número de Orçmento" required value="{{ old('internal_id') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="cnpj" class="col-sm-1 col-form-label">Cliente:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="client" id="client" placeholder="Cliente"
                                            readonly value="{{ old('client') }}">
                                            <input type="hidden" class="form-control" name="client_id" id="client_id" value="{{ old('client_id') }}">
                                        </div>
                                        <div class="col-sm-1 pl-0">
                                            <label class="custom-file-upload">
                                                <input type="button"  name="search_client" id="search_client_id">
                                                <i class="fa fa-search"></i>
                                            </label>
                                        </div>
                                        <label for="client_id" class="col-sm-1 col-form-label">CNPJ:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ/CPF" readonly value="{{ old('cnpj') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="contact" class="col-sm-1 col-form-label">Contato: </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="contact" id="contact" placeholder="Contato" required value="{{ old('contact') }}">
                                        </div>
                                        <label for="phone" class="col-sm-1 col-form-label">Telefone: </label>
                                        <div class="col-sm-3">
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone" required value="{{ old('phone') }}">
                                        </div>
                                        <label for="mail" class="col-sm-1 col-form-label">Email: </label>
                                        <div class="col-sm-3">
                                            <input type="mail" name="mail" id="mail" class="form-control" placeholder="Email" required value="{{ old('mail') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="payment_id" class="col-sm-1 col-form-label">Pagamento:</label>
                                        <div class="col-sm-5">
                                            <select  class="form-control custom-select" name="payment_id" id="payment_id" required>
                                            @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <label for="transport_id" class="col-sm-1 col-form-label">Transporte: </label>
                                        <div class="col-sm-5">
                                            <select  class="form-control custom-select" name="transport_id" id="transport_id" required>
                                            @foreach ($transports as $transport)
                                                <option value="{{ $transport->id }}">{{ $transport->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="obs" class="col-sm-1 col-form-label">Obs.: </label>
                                        <div class="col-sm-11">
                                            <textarea class="form-control" name="obs" id="obs" placeholder="Observações" required>{{ old('obs') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pt-3 border-top">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <a href="{{ route('budget.index') }}" class="btn btn-success">Voltar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.clientmodal')

@endsection

@section('scripts')



@endsection

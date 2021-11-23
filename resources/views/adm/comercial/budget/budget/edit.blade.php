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
                    <form action="{{ route('budget.update',$budget->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="client_id" class="col-sm-1 col-form-label">Número:</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="internal_id" id="internal_id" class="form-control"
                                        placeholder="Número de Orçmento" required value="{{ $budget->internal_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="cnpj" class="col-sm-1 col-form-label">Cliente:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="client" id="client" placeholder="Cliente"
                                        readonly value="{{ !is_null($budget->client) ? $budget->client->razao_social : '' }}">
                                        <input type="hidden" class="form-control" name="client_id" id="client_id" value="{{ $budget->client_id }}">
                                    </div>
                                    <div class="col-sm-1 pl-0">
                                        <label class="custom-file-upload">
                                            <input type="button"  name="search_client" id="search_client_id">
                                            <i class="fa fa-search"></i>
                                        </label>
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
                                        <input type="text" class="form-control" name="contact" id="contact" placeholder="Contato" required value="{{ $budget->contact }}">
                                    </div>
                                    <label for="phone" class="col-sm-1 col-form-label">Telefone: </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone" required value="{{ $budget->phone }}">
                                    </div>
                                    <label for="mail" class="col-sm-1 col-form-label">Email: </label>
                                    <div class="col-sm-3">
                                        <input type="mail" name="mail" id="mail" class="form-control" placeholder="Email" required value="{{ $budget->mail }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="payment_id" class="col-sm-1 col-form-label">Pagamento:</label>
                                    <div class="col-sm-5">
                                        <select  class="form-control custom-select" name="payment_id" id="payment_id" required>
                                            @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}" {{ $budget->payment_id == $payment->id ? 'Selected' : '' }}>{{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="transport_id" class="col-sm-1 col-form-label">Transporte: </label>
                                    <div class="col-sm-5">
                                        <select  class="form-control custom-select" name="transport_id" id="transport_id" required>
                                            @foreach ($transports as $transport)
                                                <option value="{{ $transport->id }}" {{ $budget->transport_id == $transport->id ? 'Selected' : '' }}>{{ $transport->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label for="obs" class="col-sm-1 col-form-label">Obs.: </label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control" name="obs" id="obs" placeholder="Observações" required>{{ $budget->obs }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success btn-sm add_more mb-3 p-2">+ Adicionar Arquivos</button>
                                        <input type='file' accept='application/pdf' name='files_budget[]' id='files_budget'
                                               multiple='multiple' hidden data-id="{{ $budget->id }}"/>
                                    </div>
                                    <div class="col-sm-4 p-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="signed" id="signed" value="0">
                                            <input class="custom-control-input" type="checkbox" id="signed_checkbox" name="signed_checkbox">
                                            <label class="custom-control-label" for="signed_checkbox">
                                            Assinado
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="overlay">
                                            <div class="w-100 d-flex justify-content-center align-items-center">
                                              <div class="spinner"></div>
                                            </div>
                                        </div>
                                        <table class="table table-sm table-hover" id="files_table">
                                            <thead>
                                                <tr>
                                                    <th>Arquivo</th>
                                                    <th>Assinado?</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($files as $file)
                                                    <tr>
                                                        <td>{{ $file->name }}</td>
                                                        <td>{{ $file->signed ? 'SIM' : 'NÃO' }}</td>
                                                        <td>
                                                            <a href="{{ $file->signed ? '' : route('pdf.signer', ['id' => $file->id]) }}"
                                                            class="btn btn-success {{ $file->signed ? 'disabled' : '' }} signer"
                                                            target="_blank" title="Assinar documento" data-id="{{ $file->id }}" id="signer_{{ $file->id }}">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a href="{{ route('file.open', $file->id) }}" class="btn btn-success"
                                                            target="_blank" title="Abrir documento">
                                                                <i class="fa fa-folder-open"></i>
                                                            </a>
                                                            <a href="{{ route('file.download', $file->id) }}" class="btn btn-success"
                                                            target="_blank" title="Baixar documento">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-danger destroy-file" id="{{ 'del_file' . $file->id }}"
                                                            title="Remover arquivo" data-id="{{ $file->id }}" data-toggle="modal"
                                                            data-target="#confirm-delete" data-msg-destroy="Deseja realmente remover esse arquivo?">
                                                                <i class="fa fa-trash"></i>
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
@include('modals.confirm-deletion-modal')

@endsection

@section('scripts')

@include('adm.comercial.budget.budget.scripts')

@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('FAÇA SEU ORÇAMENTO') }}</div>
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
                        <form method="POST" action="{{ route('orcamento.store') }}" id="budget">
                            @csrf
                            <fieldset id="servicos">
                                <h3>1. Selecione os serviços de calibração, ensaios ou produtos</h3>
                                <p><i class="fa fa-info-circle"></i> <b>Pesquise os serviços de calibração, ensaios ou produtos disponíveis,
                                habilite o item e informe a quantidade desejada. Ao final, clique em 'Próximo'.</b></p>

                                <div class="form-group">
                                    <label class="control-label" for="area">Filtrar por área</label>
                                    <select id="area" class="form-control input-lg" onchange="seacherServices() ">
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                    </select>

                                </div>
                                <table class="table" id="services">
                                    <tr>
                                        <th></th>
                                        <th>Quantidade</th>
                                        <th>Serviços de calibração, ensaios ou produtos</th>
                                        <th>Área</th>
                                        <th>Tipo</th>
                                        <th>Local</th>
                                        <th>Faixa</th>
                                        <th>Observações</th>
                                    </tr>

                                    @foreach ($services as $service)
                                    <tr>
                                        <td>
                                            <a href="#" class="btn btn-success add-service" id="{{ __('add-service-') . $service->id }}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <input type="hidden" name="{{ 'services[R' . $service->id . '][service_id]' }}"
                                            value="{{ $service->id }}" disabled="" id="{{ 'service_id_' . $service->id }}">
                                        </td>
                                        <td><input type="text" class="form-control allownumericwithoutdecimal"
                                        name="{{ 'services[R' . $service->id . '][count]' }}" disabled=""
                                        id="{{ 'service_count_' . $service->id }}"></td>
                                        <td>{{ $service->desc }}</td>
                                        <td>{{ $service->area->name }}</td>
                                        <td>{{ $service->type }}</td>
                                        <td>{{ $service->local }}</td>
                                        <td>{{ $service->range }}</td>
                                        <td><input type="text" class="form-control"
                                        name="{{ 'services[R' . $service->id . '][obs]' }}" disabled=""
                                        id="{{ 'service_obs_' . $service->id }}"></td>
                                    </tr>
                                    @endforeach
                                </table>
                                <a href="#" class="btn btn-primary" id="step_1_next">Próximo >></a>
                            </fieldset>

                            <fieldset id="terms" style="display: none">

                                <h3>2. Confirmação das condições técnicas e comerciais</h3>
                                <p><i class="fa fa-info-circle"></i>
                                    <b>  Por favor, leia as seguintes informações importantes antes de continuar. Ao final, clique em 'Próximo'.</b></p>
                                <p>Verifique nos links a seguir o escopo completo da acreditação RBC sob o numero 0127 para cada um dos Grupos de Serviços de Calibração:</p>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <a href="#" class="btn btn-primary" id="step_1_prev"><< Voltar</a>
                                        <div class="col-sm-10">
                                        <a href="#" class="btn btn-primary" id="step_2_next">Próximo >></a>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset id="client_fields" style="display: none">

                                <h3>3. Informe seus dados</h3>
                                <p><i class="fa fa-info-circle"></i> <b> Preencha os campos com seus dados. Ao final, clique em 'Próximo'.</b></p>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="contact" class="col-sm-1 col-form-label">Contato: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="contact" id="contact" id="id_sgv" placeholder="Contato" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="client" class="col-sm-1 col-form-label">Empresa: </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="client" id="client" class="form-control" placeholder="Empresa" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="client_id" class="col-sm-1 col-form-label">CNPJ / CPF: </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="client_id" id="client_id" class="form-control" placeholder="CNPJ/CPF" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-1 col-form-label">Telefone: </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="mail" class="col-sm-1 col-form-label">Email: </label>
                                            <div class="col-sm-10">
                                                <input type="mail" name="mail" id="mail" class="form-control" placeholder="Email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="payment_id" class="col-sm-1 col-form-label">Forma de  Pagamento: </label>
                                            <div class="col-sm-10">
                                                <select  class="form-control custom-select" name="payment_id" id="payment_id" required>
                                                @foreach ($payments as $payment)
                                                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="transport_id" class="col-sm-1 col-form-label">Transporte: </label>
                                            <div class="col-sm-10">
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
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="obs" id="obs" placeholder="Observações" required>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <a href="#" class="btn btn-primary" id="step_2_prev"><< Voltar</a>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

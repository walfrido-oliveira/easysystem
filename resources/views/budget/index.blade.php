@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('FAÇA SEU ORÇAMENTO') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('orcamento.store') }}">
                            @csrf
                            <fieldset id="servicos">
                                <h3>1. Selecione os serviços de calibração, ensaios ou produtos</h1>
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
                                <table class="table table-bordered" id="services">
                                    <tr>
                                        <th></th>
                                        <th>Quantidade</th>
                                        <th>Serviços de calibração, ensaios ou produtos</th>
                                        <th>Área</th>
                                        <th>Tipo</th>
                                        <th>Local</th>
                                        <th>Faixa</th>
                                    </tr>

                                    @foreach ($services as $service)
                                    <tr>
                                        <td>
                                            <a href="#" class="btn btn-success add-service" id="{{ __('add-service-') . $service->id }}"><i class="fa fa-plus"></i></a>
                                        </td>
                                        <td></td>
                                        <td>{{ $service->desc }}</td>
                                        <td>{{ $service->area->name }}</td>
                                        <td>{{ $service->type }}</td>
                                        <td>{{ $service->local }}</td>
                                        <td>{{ $service->range }}</td>
                                    </tr>
                                    @endforeach
                                </table>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

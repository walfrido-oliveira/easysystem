@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('FAÇA SEU ORÇAMENTO') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('orcamentos.store') }}">
                            @csrf
                            <fieldset id="servicos">
                                <h3>1. Selecione os serviços de calibração, ensaios ou produtos</h1>
                                <p><i class="fa fa-info-circle"></i> <b>Pesquise os serviços de calibração, ensaios ou produtos disponíveis,
                                habilite o item e informe a quantidade desejada. Ao final, clique em 'Próximo'.</b></p>

                                <div class="form-group">
                                    <label class="control-label" for="filter-area-value">Filtrar por área</label>
                                    <select id="filter-area-value" class="form-control input-lg">
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                    </select>

                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                    <div class="limiter">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">#</th>
                                            <th class="column2">Cliente</th>
                                            <th class="column3">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($budgets as $budget)
                                        <tr>
                                            <td class="column1">{{ str_pad((string)$budget->id, 5, "0", STR_PAD_LEFT)  }}</td>
                                            <td class="column2">{{ $budget->client }}</td>
                                            <td class="column3">
                                                <form action="{{ route('budget.destroy',$budget->id) }}" method="POST">
                                                    <a class="btn btn-primary" href="{{ route('budget.edit',$budget->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {!! $budgets->links() !!}
                    <div class="row p-3">
                        <a href="{{ route('orcamento.create') }}" class="btn btn-success">Novo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th width="280px">Ação</th>
                    </tr>

                    @foreach ($budgets as $budget)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $budget->client }}</td>
                        <td>
                            <form action="{{ route('orcamento.destroy',$budget->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('orcamento.show',$budget->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('orcamento.edit',$budget->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    {!! $budgets->links() !!}
                    <div class="row">
                        <a href="{{ route('orcamento.create') }}" class="btn btn-success">Nova Área</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

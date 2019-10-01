@extends('layouts.app')

@section('content')
{{ $i = 0 }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.transport.header')
                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th width="280px">Ação</th>
                    </tr>

                    @foreach ($transports as $transport)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $transport->name }}</td>
                        <td>
                            <form action="{{ route('transport.destroy',$transport->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('transport.show',$transport->id) }}">Ver</a>
                                <a class="btn btn-primary" href="{{ route('transport.edit',$transport->id) }}">Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    {!! $transports->links() !!}
                    <div class="row">
                        <a href="{{ route('transport.create') }}" class="btn btn-success">Nova forma de transporte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

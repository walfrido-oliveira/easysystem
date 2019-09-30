@extends('layouts.app')

@section('content')
{{ $i = 0 }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.service.header')
                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th width="280px">Ação</th>
                    </tr>

                    @foreach ($services as $service)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $service->desc }}</td>
                        <td>
                            <form action="{{ route('service.destroy',$service->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('service.show',$service->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('service.edit',$service->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    {!! $services->links() !!}
                    <div class="row">
                        <a href="{{ route('service.create') }}" class="btn btn-success">Novo Serviço</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

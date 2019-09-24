@extends('layouts.app')

@section('content')
{{ $i = 0 }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.area.header')
                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th width="280px">Ação</th>
                    </tr>

                    @foreach ($areas as $area)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $area->name }}</td>
                        <td>
                            <form action="{{ route('area.destroy',$area->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('area.show',$area->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('area.edit',$area->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    {!! $areas->links() !!}
                    <div class="row">
                        <a href="{{ route('area.create') }}" class="btn btn-success">Nova Área</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
{{ $i = 0 }}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.payment.header')
                </div>

                <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th width="280px">Ação</th>
                    </tr>

                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ ++$i ?? '' }}</td>
                        <td>{{ $payment->name }}</td>
                        <td>
                            <form action="{{ route('payment.destroy',$payment->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('payment.show',$payment->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('payment.edit',$payment->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    {!! $payments->links() !!}
                    <div class="row">
                        <a href="{{ route('payment.create') }}" class="btn btn-success">Nova forma de pagamento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

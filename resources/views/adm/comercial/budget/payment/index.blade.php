@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.budget.payment.header')
                </div>

                <div class="card-body">
                    <div class="limiter">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">#</th>
                                            <th class="column2">Nome</th>
                                            <th class="column3">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                        <tr>
                                            <td class="column1">{{ ++$i ?? '' }}</td>
                                            <td class="column2">{{ $payment->client }}</td>
                                            <td class="column3">
                                                <form action="{{ route('payment.destroy',$payment->id) }}" method="POST">
                                                    <a class="btn btn-primary" href="{{ route('payment.show',$payment->id) }}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-primary" href="{{ route('payment.edit',$payment->id) }}"><i class="fa fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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

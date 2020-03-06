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
                    <table-filter-component action=@json($actions)  href=@json($hrefs) csrf="{{ csrf_token() }}"
                        new_route="{{ route('payment.create') }}" sort_value=@json($sort) array_coluns=@json($columns)
                        get_router="/home/comercial/budget/payments" :edit='true'></table-filter-component>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modals.confirm-deletion-modal')
@endsection

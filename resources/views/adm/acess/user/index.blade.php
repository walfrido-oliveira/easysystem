@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.acess.user.header')
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table-filter-component action=@json($actions)  href=@json($hrefs) csrf="{{ csrf_token() }}"
                    new_route="{{ route('users.create') }}" sort_value=@json($sort) array_coluns=@json($columns)
                    get_router="/home/acess/user/users"></table-filter-component>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @include('adm.comercial.client.client.header')
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <?php $hrefs = array(); ?>
                    <?php $actions = array(); ?>
                    @foreach ($clients as $client)
                        <?php $hrefs[$client->id] =  route('client.edit',$client->id); ?>
                        <?php $actions[$client->id] = route('client.destroy',$client->id); ?>
                    @endforeach

                    <table-filter-component action=@json($actions)  href=@json($hrefs) csrf="{{csrf_token()}}" ></table-filter-component>
                </div>
                {!! $clients->links() !!}
                <div class="row p-3">
                    <a href="{{ route('client.create') }}" class="btn btn-success">Novo</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

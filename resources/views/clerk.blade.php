@extends('layouts.clerk-app')

@section('content')
<div class="container py-3">
    <div class="d-flex flex-row justify-content-center">
        <div class="col-12 col-lg-8 ">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <h3>Hello Admin</h3>

            {!! Form::open(['action' => 'ClerkController@searchFunction', 'method' => 'POST', 'role' => 'search', 'enctype' => 'multipart/form-data']) !!}
                <div class="input-group">
                    {!! Form::text('q', '', ['class' => 'form-control', 'placeholder' => 'Search Users']) !!}
                    {!! Form::submit('Search', ['class' => 'btn btn-danger rounded-0 rounded-right']) !!}
                </div>
            {!! Form::close() !!}

            @if(isset($user))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $u)
                        <tr>
                            <td>{{$u->name}}</td>
                            <td>{{$u->op}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @foreach ( $pending as $p )
                <p>{{ $p->plate }}</p>
            @endforeach

            {!! Form::open(['action' => 'ClerkController@addViolation', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::label('date', 'Date', []) !!}
                {!! Form::date('date', '', []) !!}
                {!! Form::label('place', 'Place', []) !!}
                {!! Form::text('place', '', []) !!}
                {!! Form::label('vehicle', 'Auto', []) !!}
                {!! Form::text('vehicle', '', []) !!}
                {!! Form::submit('Submit', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

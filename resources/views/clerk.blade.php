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

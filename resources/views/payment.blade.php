@extends('layouts.app')

@section('content')
<div class="container" style="overflow-x: hidden;">
    {!! Form::open(['action' => 'PagesController@payForViolations', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @foreach ($paymentData as $v)
            <h6>{{$v}}</h6>
            {!! Form::hidden('to_pay[]', $v->id ) !!}
        @endforeach
        {!! Form::submit('Zaplatiť', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container" style="overflow-x: hidden;">

    {!! Form::open(['action' => 'PagesController@payForVignettes', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @csrf
        @foreach ($paymentData as $v)
            <div class="group">
                <h6>{{$v}}</h6>
                {!! Form::hidden('to_buy[]', $v->id ) !!}
                {!! Form::select('to_buy[]', array('10 dní' => '10 dní', '30 dní' => '30 dní', '1 rok' => '1 rok'), '10 dní', ['class' => '']) !!}
                {!! Form::date('to_buy[]', '', ['class' => '__datePicker']) !!}
            </div>
        @endforeach
        {!! Form::submit('Kúpiť', ['class' => '__submit btn btn-danger']) !!}
    {!! Form::close() !!}
    <script>
        // taken from https://stackoverflow.com/questions/6982692/how-to-set-input-type-dates-default-value-to-today
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0,10);
        });
        let allDates = document.querySelectorAll('.__datePicker');
        allDates.forEach( el => {
            console.log(el);
            el.value = new Date().toDateInputValue();
        });
    </script>
</div>
@endsection
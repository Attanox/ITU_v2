@extends('layouts.app')

@section('content')
<div class="container" style="overflow-x: hidden;">

    {!! Form::open(['action' => 'PagesController@payForVignettes', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @csrf

        {{-- Table of vignettes --}}
        <table class="table table-condensed">
            <thead>
                <tr>
                    <td><strong>Vozidlo</strong></td>
                    <td class="text-left"><strong>Platné po dobu</strong></td>
                    <td class="text-left"><strong>Platné od</strong></td>
                    <td class="text-right"><strong>Cena</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentData as $v)
                    <tr>
                        <td><span class="text-monospace">{!! $v->plate !!}</span></td>
                        {!! Form::hidden('to_buy[]', $v->id ) !!}
                        <td class="text-left">{!! Form::select('to_buy[]', array('10 dní' => '10 dní', '30 dní' => '30 dní', '1 rok' => '1 rok'), '10 dní', ['class' => '', 'id' => 'sel'.$loop->index, 'onchange' => "updatePrice(".$loop->index.", this.value)"]) !!}</td>
                        <td class="text-left">{!! Form::date('to_buy[]', '', ['class' => '__datePicker']) !!}</td>
                        <td class="text-right" id={!! 'price'.$loop->index !!}>10€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Order Payment --}}
        @include('inc.payment-accordion')
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
        
        // update price of vignette in view
        function updatePrice(id, selection) {
            let prices = {
                '10 dní' : '10€',
                '30 dní' : '42€',
                '1 rok' : '666€'
            }
            
            document.getElementById('price'+id).innerHTML = prices[selection];
        };
            
    </script>
</div>
@endsection
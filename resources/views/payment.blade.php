@extends('layouts.app')

@section('content')
<div class="container" style="overflow-x: hidden;">
    {{-- Table for the individual violations --}}
    <table class="table table-condensed">
        <thead>
            <tr>
                <td><strong>Vozidlo</strong></td>
                <td class="text-left"><strong>Dátum</strong></td>
                <td class="text-right"><strong>Výška pokuty</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentData as $v)
                <tr>
                    <td>
                        @foreach ($data['vehicles'] as $i)
                            @if ($i->id == $v->vehicle_id)
                                <span class="text-monospace">{!! $i->plate !!}</span>
                            @endif
                        @endforeach
                    </td>
                    <td>{!! $v->happened_on !!}</td>
                    <td class="text-right" id={!! 'violationPrice'.$loop->index !!}>10€</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! Form::open(['action' => 'PagesController@payForViolations', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @foreach ($paymentData as $v)
            {{-- <h6>{{$v}}</h6> --}}
            {!! Form::hidden('to_pay[]', $v->id ) !!}
        @endforeach

        {{-- Payment Form --}}
        @include('inc.payment-accordion')

        {{-- {!! Form::submit('Zaplatiť', ['class' => 'btn btn-danger']) !!} --}}
    {!! Form::close() !!}
</div>
@endsection
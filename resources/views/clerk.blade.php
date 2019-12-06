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
                    {!! Form::text('q', '', ['class' => 'form-control col-9', 'placeholder' => 'Search Users']) !!}
                    {!! Form::select('type', ['Vozidlá', 'Vodiči'], 1, ['class' => 'form-control col-3 rounded-0']) !!}
                    {!! Form::submit('Search', ['class' => 'btn btn-primary __rounded-left-0 rounded-right']) !!}
                </div>
            {!! Form::close() !!}

            @if(isset($user))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Meno</th>
                            <th>Č. občianskeho preukazu</th>
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

            @if(isset($vehicle))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ŠPZ</th>
                            <th>Stav</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicle as $v)
                        <tr>
                            <td>{{$v->plate}}</td>
                            <td>{{$v->registered}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @foreach ( $pending as $p )
                <div id="pending{{ $p->id }}" class="w-100 d-flex align-items-center my-2 bg-white rounded p-2">
                    <p class="mr-auto my-auto">{{ $p->plate }}</p>
                    {{ Form::button('<i class="fas fa-check p-1"></i>', ['class' => 'btn btn-success btn-sm mr-1', 'title' => "Registrovať", 'onclick' => 'sendAccept(' . $p->id . ')'] ) }}
                    {{ Form::button('<i class="fas fa-trash-alt p-1"></i>', ['class' => 'btn btn-danger btn-sm', 'title' => "Zamietnuť", 'onclick' => 'sendReject(' . $p->id . ')'] ) }}
                </div>
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

<script>
    function sendAccept(pending_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post("/clerk/accept",
        {
            p_id: pending_id,
        },
        function(data, status){
            $('#pending'+pending_id).remove();
        });
    }

    function sendReject(pending_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post("/clerk/reject",
        {
            p_id: pending_id,
        },
        function(data, status){
            $('#pending'+pending_id).remove();
        });
    }
</script>
@endsection

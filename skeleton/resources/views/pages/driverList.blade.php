@extends('layouts.app')


@section('content')
<h1> Driver List </h1>
@if (count($drivers) > 0)
        @foreach ($drivers as $driver)
            <div class = "well">
                <small>{{$driver->name}}</small>
            </div>
        @endforeach
@endif

<h2><a href="/driver/create"> add Driver</a></h2>

@endsection
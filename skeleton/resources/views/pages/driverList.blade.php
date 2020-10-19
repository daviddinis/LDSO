@extends('layouts.app')


@section('content')
<h1> Driver List </h1>
@if (count($drivers) > 0)
        @foreach ($drivers as $driver)
            <div class = "well">
            <small>{{$driver->name}}    <a href="/driver/{{$driver->id}}/edit"> Edit</a>
            <form class="text-black mw-50" method="post" action="{{route('driver.destroy', $driver->id)}}" >
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type=" submit" class="btn bg-mydarkgreen text-white mt-1 ml-auto">Delete</button>
            </form></small>
            </div>
        @endforeach
@endif

<h2><a href="/driver/create"> add Driver</a></h2>

@endsection
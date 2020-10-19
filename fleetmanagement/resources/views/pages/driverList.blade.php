@extends('layouts.app')


@section('content')
<h2> Driver List </h2>
@if (count($drivers) > 0)
        @foreach ($drivers as $driver)
                <div class="new_item">
                <strong>Name:</strong> {{$driver->name}} <br>
                <strong>Email:</strong> {{$driver->email}} <br>
                <strong>Driver License:</strong> {{$driver->drivers_license}} <br>
                <button onclick="window.location.href='/driver/{{$driver->id}}/edit'"> Edit </button>
                <form class="text-black mw-50" method="post" action="{{route('driver.destroy', $driver->id)}}" >
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type=" submit" class="btn bg-mydarkgreen text-white mt-1 ml-auto">Delete</button>
                </form>
        @endforeach
@endif

<button onclick="window.location.href='/driver/create'"> add Driver</button>

@endsection
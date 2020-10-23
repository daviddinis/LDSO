@extends('layouts.app')


@section('content')
<form class="text-black mw-50" method="post" action="{{route('driver.update', $driver->id)}}" >
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <label class="">Name:<input id="name" type="text" name="name" class="" value={{$driver->name}} required></label>
    <label class="">Email:<input id="email" type="email" name="email" class="" value={{$driver->email}}></label>
    <label class="">Driver License:<input id="drivers_license" type="text" name="drivers_license" class="" value={{$driver->drivers_license}}></label>
    <label class="">Identification Card:<input id="id_card" type="number" name="id_card" class="" value={{$driver->id_card}}></label>
    <button type=" submit" class="btn bg-mydarkgreen text-white mt-1 ml-auto">Submit</button>
</form>

@endsection


@extends('layouts.app')


@section('content')
<form class="text-black mw-50" method="post" action="{{route('driver.store')}}" >
    {{ method_field('POST') }}
    {{ csrf_field() }}

    <label class="">Name:<input id="name" type="text" name="name" class="" required></label>
    <label class="">Email:<input id="email" type="email" name="email" class=""></label>
    <label class="">Driver License:<input id="drivers_license" type="text" name="drivers_license" class=""></label>
    <label class="">Identification Card:<input id="id_card" type="number" name="id_card" class=""></label>
    <button type=" submit" class="btn bg-mydarkgreen text-white mt-1 ml-auto">Submit</button>
</form>

@endsection


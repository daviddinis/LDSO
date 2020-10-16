@extends('layouts.app')


@section('content')
<form class="text-black mw-50" method="post" action="{{route('makeCar')}}" >
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <label class="">Brand:<input id="brand" name="brand" class="" required></label>
    <label class="">Model:<input id="model" name="model" class="" required></label>
    <label class="">Plate:<input id="plate" name="plate" class="" required></label>
    <button type=" submit" class="btn bg-mydarkgreen text-white mt-1 ml-auto">Submit</button>
</form>

@endsection

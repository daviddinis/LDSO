@extends('layouts.app')


@section('content') 
<form class="text-black w-25 d-flex flex-column align-items-center" method="post" action="{{route('makeCar')}}">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group d-flex flex-column align-items-end">
    <label class="form-group ">Brand:<input id="brand" name="brand" class="" required></label>
    <label class="form-group  ">Model:<input id="model" name="model" class="" required></label>
    <label class="form-group ">Plate:<input id="plate" name="plate" class="" required></label>
    <label class="form-group ">Acquired in:<input id="date" name="date" type="date" class="" required></label>
    <label class="form-group">Mileage:<input id="mileage" name="mileage" class=""></label>
    <label class="form-group">Value:<input id="value" name="value" class=""></label>


    </div>

    <div class="file-field form-group">
        <div class="d-flex justify-content-end">
            <img src="https://www.lizdrive.pt/wp-content/themes/webspark-ford-es-theme/images/placeholder-ford.webp" class="rounded-circle z-depth-1-half avatar-pic " width=80 height="80" alt="Placeholder avatar">
            <div class="mt-2 ml-2 d-flex flex-column ">
                <span>Add photo</span>
                <input class="" name="image" type="file">
            </div>
        </div>
    </div>


    <button type=" submit" class="text-white ml-auto" >Submit</button>
</form>

@endsection

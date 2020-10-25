@extends('layouts.app')


@section('content')
<div class="container-md">
    <form method="POST" action="{{route('driver.update', $driver->id)}}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Edit Driver</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{$driver->name}}" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" value="{{$driver->email}}" name="email">
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Driver's License</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="drivers_license" value="{{$driver->drivers_license}}" name="drivers_license">
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">ID Card</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="id_card" value="{{$driver->id_card}}" name="id_card">
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg">Update</button>
            </div>
        </div>
    </form>
</div>

@endsection


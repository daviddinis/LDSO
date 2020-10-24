@extends('layouts.app')


@section('content')
<div class="container-md">
    <form method="POST" action="{{route('driver.store')}}">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Add Driver</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Driver's License</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="drivers_license" name="drivers_license">
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">ID Card</label>
                <div class="input-group">
                    <input type="number" placeholder="Optional" class="form-control" id="id_card" name="id_card">
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg">Add</button>
            </div>
        </div>
    </form>
</div>

@endsection
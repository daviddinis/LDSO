@extends('layouts.app')


@section('content')
<div class="container-md">
    <form method="POST" action="{{route('car.store')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Add Car</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Brand</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="brand" name="brand" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Model</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Plate</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="plate" name="plate" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Date Acquired</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Mileage</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="mileage" name="mileage">
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Photo</label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="photo" id="photo">
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
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
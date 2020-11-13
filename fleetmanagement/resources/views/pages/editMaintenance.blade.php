@extends('layouts.app')


@section('content')
@if ($errors->any())
    <br>
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h2>Error</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
<div class="container-md">
    <form method="POST" action="{{route('maintenance.update', [$car->id, $maintenance->id])}}" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Edit Maintenance</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Date</label>
                <div class="input-group">
                <input type="date" class="form-control" id="date" name="date" value="{{$maintenance->date}}" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Next Maintenance Date</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date" value="{{$maintenance->next_maintenance_date}}">
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Value</label>
                <div class="input-group">
                    <input type="number" class="form-control" min="0" step=".01" id="value" name="value" value="{{$maintenance->value}}" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Mileage</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="mileage" name="mileage" value="{{$maintenance->kilometers}}" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Observations</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="observations" name="observations" value="{{$maintenance->obs}}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">File</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="file" name="file" value="{{$maintenance->file}}">
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
    </div>
    </form>
</div>

@endsection
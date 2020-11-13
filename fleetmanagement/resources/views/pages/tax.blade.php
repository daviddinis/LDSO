@extends('layouts.app')

@section('content')
<div class="jumbotron" style="padding-top: 3%;padding-bottom: 20%">
    <ol class="breadcrumb" style="border-width: 0">
        <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
            </a></li>

        <li class="breadcrumb-item active"><a href="{{route('tax.find', $car->id)}}">
            <p>Taxes</p>
        </a></li>
        <li class="breadcrumb-item active">Tax {{$tax->id}}</li>
    </ol>
    <div class="container-md">
            {{ csrf_field() }}
            <div class="row" style="margin-top: 5%">
                <div class="col-md-2"></div>
                <div class="col">
                    <h1>Tax {{$tax->id}}</h1>
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h5><strong>Date of the most recent tax: </strong>{{$tax->date}}</h5>
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <h5><strong>Expiration date of the tax: </strong>{{$tax->expiration_date}}</h5>
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                <h5><strong>Tax value: </strong>{{$tax->value}}€</h5>
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                <h5><strong>File: </strong>@if($tax->file != null) <a href="{{ asset($tax->file) }}" style="color: black" download="{{substr($tax->file, 17)}}">Download File</a> @else N/A @endif</h5>
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                <h5><strong>Observations: </strong>{{$tax->obs}}</h5>
                </div>
            </div>
            <br>
    </div>
</div>
@endsection
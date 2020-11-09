@extends('layouts.app')

@section('content')
<div class="container-md">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Taxes</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <h5>Date of the most recent tax: {{$car->taxes->first()->date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <h5>Expiration date of the tax: {{$car->taxes->first()->expiration_date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Tax value: {{$car->taxes->first()->value}}€</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>File: {{$car->taxes->first()->file}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Observations: {{$car->taxes->first()->obs}}</h5>
            </div>
        </div>
        <br>
        <div class="col col-md-auto" id="settingsEditButton">
            <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/taxes/edit">Edit</a></button>
        </div>
</div>
@endsection
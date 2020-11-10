@extends('layouts.app')

@section('content')
<div class="container-md">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Most Recent Tax</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <h5>Date of the most recent tax: {{$tax->date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <h5>Expiration date of the tax: {{$tax->expiration_date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Tax value: {{$tax->value}}€</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>File: {{$tax->file}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Observations: {{$tax->obs}}</h5>
            </div>
        </div>
        <br>
</div>
@endsection
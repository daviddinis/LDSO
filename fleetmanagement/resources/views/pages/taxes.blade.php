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
                <h5>Date of the most recent tax: {{$car->taxes->last()->date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <h5>Expiration date of the tax: {{$car->taxes->last()->expiration_date}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Tax value: {{$car->taxes->last()->value}}€</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>File: {{$car->taxes->last()->file}}</h5>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
            <h5>Observations: {{$car->taxes->last()->obs}}</h5>
            </div>
        </div>
        <br>
        <div class="col col-md-auto" id="settingsEditButton">
            <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/taxes/edit">Edit</a></button>
        </div>
        <br>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="table-primary">
                <th scope="col">Tax</th>
                <th scope="col">From </th>
                <th scope="col">To</th>
                <th scope="col">Value</th>
            </tr>
            </thead>
            <tbody>
                @foreach($car->taxes as $tax)
                <tr>
                <th scope="row"><a href="/car/{{$car->id}}/taxes/tax/{{$tax->id}}">Tax {{$tax->id}}</a>
                </th>
                <td>{{$tax->date}}</td>
                <td>{{$tax->expiration_date}}</td>
                <td>{{$tax->value}}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="col col-md-auto" id="settingsEditButton">
            <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/taxes/add">Add Tax</a></button>
        </div>
</div>
@endsection
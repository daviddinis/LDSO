@extends('layouts.app')

@section('content')


<div class="jumbotron" style="padding-top: 3%">
    <ol class="breadcrumb" style="border-width: 0">
        <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
            </a></li>

        <li class="breadcrumb-item active">Taxes</li>
    </ol>
    <div class="row" style="margin-top: 5%">
    <div class="col-md-2"></div>
        <div class="col">
            <h1>Most Recent Tax</h1>
        </div>
    </div>
    <br>
    <div class="row form-group">
        <div class="col-md-2"></div>
        <div class="col-md-8">
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
        <h5>File: @if($car->taxes->last()->file != null) <a href="{{ asset($car->taxes->last()->file) }}" style="color: black" download="{{substr($car->taxes->last()->file, 17)}}">Download File</a> @else N/A @endif</h5>
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

    <table class="table table-hover">
        <thead>
            <tr >
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">Value</th>
                <th scope="col">File</th>
                <th scope="col">Observations</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taxes as $tax)
            <tr class="table-primary">
                <th scope="row"  id="tax_button"><a href="/car/{{$car->id}}/taxes/tax/{{$tax->id}}">{{$tax->id}}</a></th>
                <td>{{$tax->date}}</td>
                <td>{{$tax->expiration_date}}</td>
                <td>{{$tax->value}}€</td>
                <td>@if($tax->file != null) <a href="{{ asset($tax->file) }}" style="color: white" download="{{substr($tax->file, 17)}}">Download File</a> @else N/A @endif </td>
                <td>@if($tax->obs != null){{$tax->obs}} @else N/A @endif</td>
                <td>
                    <form style="margin-left: 10px; float: right;" method="post" action="{{route('tax.destroy', [$car->id, $tax->id])}}" >
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                    </form>

                    <a href= {{route('tax.edit', [$car->id, $tax])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{route('tax.create', $car->id)}}" class="btn btn-primary btn-lg rounded-circle " style="position:absolute;bottom:2px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection
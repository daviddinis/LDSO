@extends('layouts.app')

@section('content')


<div class="jumbotron" style="padding-top: 3%">
    <ol class="breadcrumb" style="border-width: 0">
        <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
            </a></li>

        <li class="breadcrumb-item active">Taxes</li>
    </ol>
    <h3>Active tax</h3>

    @if($activeDaysLeft < 0 && $activeTax != null)
        <div class="card text-white bg-danger mb-3" style="margin: auto">
            <div class="card-header">Invalid</div>
            <div class="card-body">
            <h4 class="card-title">Your tax has expired! This vehicle is not fit for use</h4>
            <h5>{{'Expired on: ' . $activeTax->expiration_date}}</h5>
        </div>
    @elseif($activeDaysLeft > 0 && $activeTax != null)
        <div class="card text-white bg-success mb-3" style="margin: auto;">
            <div class="card-header">Valid
                <form style="margin-left: 10px; float: right;" method="post" action="{{route('tax.destroy', [$car->id ,$activeTax->id])}}" >
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                </form>
                <a href= {{route('tax.edit', [$car->id, $activeTax])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
            </div>
            <div class="card-body">
                @if($activeTax->file != null)
                <button style="float:right;" type="button" class="btn btn-secondary">
                    <a href="{{ asset($activeTax->file) }}" style="color:black;" download="{{substr($activeTax->file, 9)}}">Download File</a>
                </button>
        @endif

            <h4 class="card-title">{{'This vehicle has a valid tax for ' . $activeDaysLeft . ' more days'}}</h4>
            @if($activeDaysLeft - $redAlert < 0)
                <span class="badge badge-danger"><h5>Your tax is about to expire</h5></span>
            @elseif($activeDaysLeft - $yellowAlert < 0)
                <span class="badge badge-warning"><h5>Your tax will expire soon, please consider renewing it</h5></span>
            @else
                <span class="badge badge-primary"><h5>A warning will be issued in {{$activeDaysLeft - $yellowAlert}} days</h5></span>
            @endif
            <ul class="list-group list-group-flush" style="margin-top:2%">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Acquired on</th>
                        <th scope="col">Expires on</th>
                        <th scope="col">Value</th>
                        <th scope="col">Observations</th>
                      </tr>
                    </thead>

                    <tr class="table-primary">
                        <th scope="row">tax</th>
                        <th>{{$activeTax->date}}</th>
                        <th>{{$activeTax->expiration_date}}</th>
                        <th>{{$activeTax->value . '€'}}</th>
                        <th>{{$activeTax->obs}}</th>                            
                    </tr>
                </table>
            </div>
        
    @else 
        <div class="card text-white bg-danger mb-3" style="margin: auto;">
            <div class="card-header">Invalid</div>
            <div class="card-body">
            <h4 class="card-title">This vehicle has no recorded tax data!</h4>
        </div>
    @endif
</div>
<h3>Tax History</h3>

    <table class="table table-hover">
        <thead>
            <tr class="table-active">
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">Value</th>
                <th scope="col">Observations</th>
                <th scope="col">File</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taxes as $tax)
            <tr class="table-primary">
                <th scope="row" id="tax_button"><a href="/car/{{$car->id}}/taxes/tax/{{$tax->id}}">{{$tax->id}}</th>
                <td>{{$tax->date}}</td>
                <td>{{$tax->expiration_date}} Km</td>
                <td>{{$tax->value}}€</td>
                <td>@if($tax->obs != null){{$tax->obs}} @else N/A @endif</td>
                <td>@if($tax->file != null) <a href="{{ asset($tax->file) }}" style="color: white" download="{{substr($tax->file, 9)}}">Download File</a> @else N/A @endif </td>
                <td>
                    <form style="margin-left: 10px; float: right;" method="post" action="{{route('tax.destroy', [$car->id ,$tax->id])}}" >
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
<a href="{{route('tax.create', $car->id)}}" class="btn btn-primary btn-lg rounded-circle" style="float: right;">
    <i class="fa fa-plus"></i>
</a>


@endsection
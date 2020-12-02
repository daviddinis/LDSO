@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="padding-top: 3%">
        <ol class="breadcrumb" style="border-width: 0">
            <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                    <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
                </a></li>

            <li class="breadcrumb-item active">Insurances</li>
        </ol>
        <h3>Active Insurance</h3>

        @if($activeDaysLeft < 0 && $activeInsurance != null)
            <div class="card text-white bg-danger mb-3" style="margin: auto">
                <div class="card-header">Invalid</div>
                <div class="card-body">
                <h4 class="card-title">Your insurance has expired! This vehicle is not fit for use</h4>
                <h5>{{'Expired on: ' . $activeInsurance->expiration_date}}</h5>
            </div>
        @elseif($activeDaysLeft > 0 && $activeInsurance != null)
            <div class="card text-white bg-success mb-3" style="margin: auto;">
                <div class="card-header">Valid
                    <form style="margin-left: 10px; float: right;" method="post" action="{{route('insurance.destroy', [$car->id ,$activeInsurance->id])}}" >
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                    </form>
                    <a href= {{route('insurance.edit', [$car->id, $activeInsurance])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                </div>
                <div class="card-body">
                    @if($activeInsurance->file != null)
                    <button style="float:right;" type="button" class="btn btn-secondary">
                        <a href="{{ asset($activeInsurance->file) }}" style="color:black;" download="{{substr($activeInsurance->file, 15)}}">Download File</a>
                    </button>
                @endif

                <h4 class="card-title">{{'This vehicle has a valid insurance for ' . $activeDaysLeft . ' more days'}}</h4>
                @if($activeDaysLeft - $redAlert < 0)
                    <span class="badge badge-danger"><h5>Your insurance is about to expire</h5></span>
                @elseif($activeDaysLeft - $yellowAlert < 0)
                    <span class="badge badge-warning"><h5>Your insurance will expire soon, please consider renewing it</h5></span>
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
                            <th scope="row">Insurance</th>
                            <th>{{$activeInsurance->date}}</th>
                            <th>{{$activeInsurance->expiration_date}}</th>
                            <th>{{$activeInsurance->value . '€'}}</th>
                            <th>{{$activeInsurance->obs}}</th>                            
                        </tr>
                    </table>
                </div>
        @elseif($activeDaysLeft == 0 && $activeInsurance != null)
        <div class="card text-white bg-success mb-3" style="margin: auto;">
                <div class="card-header">Valid
                    <form style="margin-left: 10px; float: right;" method="post" action="{{route('insurance.destroy', [$car->id ,$activeInsurance->id])}}" >
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                    </form>
                    <a href= {{route('insurance.edit', [$car->id, $activeInsurance])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                </div>
        <div class="card-body">
            @if($activeInsurance->file != null)
                <button style="float:right;" type="button" class="btn btn-secondary">
                    <a href="{{ asset($activeInsurance->file) }}" style="color:black;" download="{{substr($activeInsurance->file, 15)}}">Download File</a>
                </button>
            @endif

            <h4 class="card-title">{{'This vehicle has a valid tax only until today'}}</h4>
            @if($activeDaysLeft - $redAlert < 0)
                    <span class="badge badge-danger"><h5>Your insurance is about to expire</h5></span>
                @elseif($activeDaysLeft - $yellowAlert < 0)
                    <span class="badge badge-warning"><h5>Your insurance will expire soon, please consider renewing it</h5></span>
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
                            <th scope="row">Insurance</th>
                            <th>{{$activeInsurance->date}}</th>
                            <th>{{$activeInsurance->expiration_date}}</th>
                            <th>{{$activeInsurance->value . '€'}}</th>
                            <th>{{$activeInsurance->obs}}</th>                            
                        </tr>
                </table>
            </div>
            
        @else 
            <div class="card text-white bg-danger mb-3" style="margin: auto;">
                <div class="card-header">Invalid</div>
                <div class="card-body">
                <h4 class="card-title">This vehicle has no recorded insurance data!</h4>
            </div>
        @endif
    </div>
        <h3>Insurance History</h3>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Expiration date</th>
                    <th scope="col">Value</th>
                    <th scope="col">Observations</th>
                    <th scope="col">File</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insurances as $insurance)
                <tr class="table-primary">
                    <th scope="row">{{$insurance->id}}</th>
                    <td>{{$insurance->date}}</td>
                    <td>{{$insurance->expiration_date}} </td>
                    <td>{{$insurance->value}}€</td>
                    <td>@if($insurance->obs != null){{$insurance->obs}} @else N/A @endif</td>
                    <td>@if($insurance->file != null) <a href="{{ asset($insurance->file) }}" style="color: white" download="{{substr($insurance->file, 17)}}">Download File</a> @else N/A @endif </td>
                    <td>
                        <form style="margin-left: 10px; float: right;" method="post" action="{{route('insurance.destroy', [$car->id ,$insurance->id])}}" >
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                        </form>

                        <a href= {{route('insurance.edit', [$car->id, $insurance])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{route('insurance.create', $car->id)}}" class="btn btn-primary btn-lg rounded-circle" style="float: right;">
        <i class="fa fa-plus"></i>
    </a>

@endsection

@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="padding-top: 3%">
        <ol class="breadcrumb" style="border-width: 0">
            <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                    <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
                </a></li>

            <li class="breadcrumb-item active">inspections</li>
        </ol>
        <h3>Active inspection</h3>

        @if($activeDaysLeft < 0 && $activeInspection != null)
            <div class="card text-white bg-danger mb-3" style="margin: auto">
                <div class="card-header">Invalid</div>
                <div class="card-body">
                <h4 class="card-title">Your inspection has expired! This vehicle is not fit for use</h4>
                <h5>{{'Expired on: ' . $activeInspection->expiration_date}}</h5>
            </div>
        @elseif($activeDaysLeft > 0 && $activeInspection != null)
            <div class="card text-white bg-success mb-3" style="margin: auto;">
                <div class="card-header">Valid
                    <form style="margin-left: 10px; float: right;" method="post" action="{{route('inspection.destroy', [$car->id ,$activeInspection->id])}}" >
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                    </form>
                    <a href= {{route('inspection.edit', [$car->id, $activeInspection])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                </div>
                <div class="card-body">
                    @if($activeInspection->file != null)
                    <button style="float:right;" type="button" class="btn btn-secondary">
                        <a href="{{ asset($activeInspection->file) }}" style="color:black;" download="{{substr($activeInspection->file, 16)}}">Download File</a>
                    </button>
                @endif

                <h4 class="card-title">{{'This vehicle has a valid inspection for ' . $activeDaysLeft . ' more days'}}</h4>
                @if($activeDaysLeft - $redAlert < 0)
                    <span class="badge badge-danger"><h5>Your inspection is about to expire</h5></span>
                @elseif($activeDaysLeft - $yellowAlert < 0)
                    <span class="badge badge-warning"><h5>Your inspection will expire soon, please consider renewing it</h5></span>
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
                            <th scope="row">inspection</th>
                            <th>{{$activeInspection->date}}</th>
                            <th>{{$activeInspection->expiration_date}}</th>
                            <th>{{$activeInspection->value . '€'}}</th>
                            <th>{{$activeInspection->obs}}</th>                            
                        </tr>
                    </table>
                </div>
            
        @else 
            <div class="card text-white bg-danger mb-3" style="margin: auto;">
                <div class="card-header">Invalid</div>
                <div class="card-body">
                <h4 class="card-title">This vehicle has no recorded inspection data!</h4>
            </div>
        @endif
    </div>
        <h3>Inspection History</h3>

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
                @foreach ($inspections as $inspection)
                <tr class="table-primary">
                    <th scope="row">{{$inspection->id}}</th>
                    <td>{{$inspection->date}}</td>
                    <td>{{$inspection->expiration_date}} Km</td>
                    <td>{{$inspection->value}}€</td>
                    <td>@if($inspection->obs != null){{$inspection->obs}} @else N/A @endif</td>
                    <td>@if($inspection->file != null) <a href="{{ asset($inspection->file) }}" style="color: white" download="{{substr($inspection->file, 17)}}">Download File</a> @else N/A @endif </td>
                    <td>
                        <form style="margin-left: 10px; float: right;" method="post" action="{{route('inspection.destroy', [$car->id ,$inspection->id])}}" >
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i class="fa fa-trash"></i></button>
                        </form>

                        <a href= {{route('inspection.edit', [$car->id, $inspection])}} class="btn btn-info btn-sm rounded-circle" style="float:right"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$inspections->links()}}</div>
    </div>
    <a href="{{route('inspection.create', $car->id)}}" class="btn btn-primary btn-lg rounded-circle" style="float: right;">
        <i class="fa fa-plus"></i>
    </a>

@endsection

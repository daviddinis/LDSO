@extends('layouts.app')

@section('title', 'Car')

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


@php
    // Function to add all costs from each category (tax, inspection, etc.)
    function sum_costs($arr)
    {
        $total = 0;
        foreach ($arr as $obj)
        {
            $total += $obj['value'];
        }
        return $total;
    }

    // Function to return the if the car is in use/was last used by
    function last_used_by($car)
    {
        $last_driver = $car->drivers->first();
        if($last_driver != null)
        {
            // there is a driver
            $dates = $last_driver->pivot;

            if($dates->end_date !== null)
            {
                if(date($dates->end_date) < date('Y-m-d')) return '<span class="badge badge-pill badge-warning">Last used by ' . $last_driver->name . ' between ' . $dates->start_date . ' and ' . $dates->end_date . '</span>';
                else return '<span class="badge badge-pill badge-danger">In use by ' . $last_driver->name . ' from ' . $dates->start_date . ' until ' . $dates->end_date . "</span>";
            }
            else return '<span class="badge badge-pill badge-danger">In use by ' . $last_driver->name . ' from ' . $dates->start_date . '</span>';
        }
        else return '<span class="badge badge-pill badge-success">Car is available!</span>';
    }
 @endphp


<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-auto mr-auto">
                <h1 class="display-3">{{$car->make}} {{$car->model}} </h1>
                <br>
                <p>{{$car->license_plate}}</p>
                <br>
                <p class="lead">Total cost: @php echo sum_costs($car->taxes) + sum_costs($car->maintenances) + sum_costs($car->inspections) + sum_costs($car->insurances); @endphp €</p>
            </div>
            <div class="col-md-auto">
                @if(isset($car->image))
                    <img style="border:1px solid black" src="{{ asset('img/' . $car->image) }}" alt="tag">
                @endif
            </div>
            </div>
    </div>
    <hr class="my-4">

    <div class="container">

        <div class="row" style="margin-top:5%;">
            <div class="col">
            <h4>
                @php echo last_used_by($car); @endphp
            </h4>
            </div>
            <!-- TODO does nothing currently -->
        </div>

        <div class="row" style="margin-bottom: 5%;">
            <div class="col">
                @if (strpos(last_used_by($car), 'available'))
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignDriverModal">Assign new driver</button>
                @else
                    <form action="{{route('cardriver.destroy', $car->drivers->first()->pivot->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Remove driver</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <form method="POST" action="{{route('cardriver.store')}}">
            {{ csrf_field() }}
            <div class="modal fade" style="padding-top: 3%" id="assignDriverModal" tabindex="-1" role="dialog" aria-labelledby="assignDriverModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignDriverModalLabel">Assign Driver</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col-1"></div>
                            <label for="driver_id">Select a driver or create a new one <a href="{{route('driver.create')}}">here</a>:</label>
                        </div>
                        <div class="row" style="padding-left: 5%">
                            <div class="col-1"></div>
                            <select name="driver_id" id="driver_id" required>
                                <option value=""></option>
                                @foreach ($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-5">
                                <label for="start_date">Starting:</label>
                                <input type="date" name="start_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" id="start_date" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-5">
                                <label for="end_date">Ending:</label>
                                <input type="date" name="end_date" id="end_date" min="{{ (new DateTime('tomorrow'))->format('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="car_id" value="{{$car->id}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col">
                <a href="{{route('maintenance.find', $car->id)}}">
                    <div class=" card text-white bg-primary mb-3" style="max-width: 40rem;">
                        <div class="card-header">Maintenances</div>
                        <div class="card-body">
                            @if(count($car->maintenances) !== 0)
                                <h4 class="card-title">Total: {{count($car->maintenances)}} @if(count($car->maintenances))@endif</h4>
                                <p class="card-text">Latest: {{ $car->maintenances->first()->date}}</p>
                            @else
                                <p class="card-text">No recorded<br>maintenances!</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{route('insurance.find', $car->id)}}">
                    <div class=" card text-white bg-primary mb-3" style="max-width: 40rem;">
                        <div class="card-header">Insurance</div>
                        <div class="card-body">
                            @if(count($car->insurances) !== 0)
                                <h4 class="card-title">Total: {{count($car->insurances)}} @if(count($car->insurances))@endif</h4>
                                <p class="card-text">Latest: {{$car->insurances->first()->date}}</p>
                            @else
                                <p class="card-text">No recorded<br>insurances!</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <div class=" card text-white bg-primary mb-3" style="max-width: 40rem;">
                    <div class="card-header">Taxes</div>
                    <div class="card-body">
                        @if(count($car->taxes) !== 0)
                            <h4 class="card-title">Total: {{count($car->taxes)}} @if(count($car->taxes))@endif</h4>
                            <p class="card-text">Latest: {{$car->taxes->first()->date}}</p>
                        @else
                            <p class="card-text">No recorded<br>taxes!</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <a href="{{route('inspection.find', $car->id)}}">
                    <div class=" card text-white bg-primary mb-3" style="max-width: 40rem;">
                        <div class="card-header">Inspections</div>
                        <div class="card-body">
                            @if(count($car->inspections) !== 0)
                                <h4 class="card-title">Total: {{count($car->inspections)}} @if(count($car->inspections))@endif</h4>
                                <p class="card-text">Latest: {{$car->inspections->first()->date}}</p>
                            @else
                                <p class="card-text">No recorded<br>inspections!</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row justify-content-end" style="margin-top:20%;">

            <div class="col col-md-auto">
                <a href="{{route('alerts', ['id' => $car->id])}}" class="btn btn-primary">Settings</a>


            </div>
            <!-- TODO does not work currently -->
            <div class="col col-md-auto">
                <button type="button" class="btn btn-danger">Delete car</button>
            </div>

        </div>

    </div>
</div>
@endsection
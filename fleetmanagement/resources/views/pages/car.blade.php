@extends('layouts.app')

@section('title', 'Car')

@section('styles')
<link href="{{ asset('css/car.css') }}" rel="stylesheet">
@endsection

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

    //returns alert date string in format Y-m-d
    //$eventdate -> event date, $alertTolerance -> alert time in days (date used to notify x days before the event)
    function eventDate($eventDate, $alertTolerance){

    $dateTime = new DateTime($eventDate);
    $alertInterval = new DateInterval("P" . $alertTolerance . "D");
    $alertDateTime = new DateTime($eventDate);
    $alertDateTime->sub($alertInterval);


    return $alertDateTime->format('Y-m-d');
    }

    //similar to timeToEvent but merely returns the integer that represents the number of days  
    function timeToEventInt($currentDate, $eventDate, $alertTolerance){

    $dateTime = new DateTime($currentDate);
    $alertDateTime = new DateTime(eventDate($eventDate, $alertTolerance));


    $alertDateInterval = date_diff($dateTime, $alertDateTime);

    return intval(str_replace(' days', '', $alertDateInterval->format('%r%a days') ) );

    }

    //similar to currentTimeToEvent but merely returns the integer that represents the number of days
    function currentTimeToEventInt($eventDate, $alertTolerance){
    return timeToEventInt(date("Y-m-d"), $eventDate, $alertTolerance);
    }

    function getTypeAndTimeToEvent($yellow_alert, $red_alert, $eventDate){

        $yellowTime = currentTimeToEventInt($eventDate, $yellow_alert);
        $redTime = currentTimeToEventInt($eventDate, $red_alert);
        $overdueTime = currentTimeToEventInt($eventDate, 0);
        if ($overdueTime < 0)
        {
            $alertTimeToType = 'overdue';
            $alertTypeColour = 'overdue';
            $alertTime = $overdueTime;
        }
        else if ($redTime < 0)
        {
            $alertTimeToType = 'overdue';
            $alertTypeColour = 'red';
            $alertTime = $overdueTime;
        }
        else if($yellowTime < 0)
        {
            $alertTimeToType = 'red';
            $alertTypeColour = 'yellow';
            $alertTime = $redTime;
        }
        else {
            $alertTimeToType = 'yellow';
            $alertTypeColour = 'green';
            $alertTime = $yellowTime;
        }

        return array('timerType' => $alertTimeToType, 'typeColour' => $alertTypeColour, 'time' => $alertTime);
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
            @include('partials.vehicleEvent', ['route_name' => 'maintenance', 'events' => $car->maintenances, 'eventDate' => $maintenanceDate])

            @include('partials.vehicleEvent', ['route_name' => 'insurance', 'events' => $car->insurances, 'eventDate' => $insuranceDate])

            @include('partials.vehicleEvent', ['route_name' => 'tax', 'events' => $car->taxes, 'eventDate' => $taxDate])

            @include('partials.vehicleEvent', ['route_name' => 'inspection', 'events' => $car->inspections, 'eventDate' => $inspectionDate])
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
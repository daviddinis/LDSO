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
        $last_driver = $car->carDriver()->orderBy('end_date', 'desc')->first();
	        if($last_driver != null)
	        {
	            // there is a driver
	            //$dates = $last_driver->pivot;
	
	            if($last_driver->end_date !== null)
	            {
                    if(date($last_driver->end_date) < date('Y-m-d')) return '<div class="col-auto"><span class="badge badge-pill badge-success">Car is available!</span></div><div class="col-auto"><span class="badge badge-pill badge-warning">Last used by ' . $last_driver->driver->name . ' between ' . $last_driver->start_date . ' and ' . $last_driver->end_date . '</span></div>';
                else return '<div class="col-auto"><span class="badge badge-pill badge-danger">In use by ' . $last_driver->driver->name . ' from ' . $last_driver->start_date . ' until ' . $last_driver->end_date . "</span></div>";
            }
            else return '<div class="col-auto"><span class="badge badge-pill badge-danger">In use by ' . $last_driver->driver->name . ' from ' . $last_driver->start_date . '</span></div>';
        }
        else return '<div class="col-auto"><span class="badge badge-pill badge-success">Car is available!</span></div>';

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
                <img height="240" width="240" src="{{ asset('img/' . $car->image) }}" alt="uploaded car image">
                @else
                <img height="240" width="240" src="{{ asset('img/cc_defaultimg.png') }}" alt="default car image">
                @endif
                
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="container">
        <div class="row">
            <h2 class="">Statistics </h2>
        </div>
        <div class="row">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#drivers">Cost</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#hide">Don't show</a>
              </li>
            </ul>
                <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active show" id="drivers">
                    <canvas id="cost-chart" width="960px" height="300px"></canvas>
                </div>
                <div class="tab-pane fade" id="mileage">            
                    <!-- Put another graph here! -->
                    <div style="height:300px; width:960px;">
                        <canvas id="bar2-chart" width="960px" height="300px"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade" id="issues">
                    <!-- Put another graph here! -->
                    <p>Put another graph here!</p>  
                </div>
                <div class="tab-pane fade" id="hide">
                    <!-- Don't put anything here :) -->
                </div>
            </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>

    function padChartData(labels, data)
    {
        const filledMonths = data.map((month) => month.x);
        const dataset = labels.map(month => {
        const indexOfFilledData = filledMonths.indexOf(month);
        if( indexOfFilledData!== -1) return data[indexOfFilledData].y;
        return null;
        });
        return dataset;
    }

    var chartLabels = @php echo $graphLabels; @endphp;
    var maintenanceChartValues = @php echo $maintenanceValues; @endphp;
    var taxChartValues = @php echo $taxValues; @endphp;
    var insuranceChartValues = @php echo $insuranceValues; @endphp;
    var inspectionChartValues = @php echo $inspectionValues; @endphp;

    // Multiple line chart for car cost
    new Chart(document.getElementById("cost-chart"), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [               
            {
                label: "Accumulated amount (Maintenance)",
                fill: false,
                borderColor: "red",
                backgroundColor:"red",
                pointFillColor: "red",
                steppedLine:false,
                pointHoverBorderColor: "red",
                pointRadius:5,
                data: padChartData(chartLabels,maintenanceChartValues)
            },   
            {
                label: "Accumulated amount (Tax)",
                fill: false,
                borderColor: "green",
                backgroundColor:"green",
                pointFillColor: "green",
                steppedLine:false,
                pointHoverBorderColor: "green",
                pointRadius:5,
                data: padChartData(chartLabels,taxChartValues)
            },   
            {
                label: "Accumulated amount (Insurance)",
                fill: false,
                borderColor: "blue",
                backgroundColor:"blue",
                pointFillColor: "blue",
                steppedLine:false,
                pointHoverBorderColor: "blue",
                pointRadius:5,
                data: padChartData(chartLabels,insuranceChartValues)
            },   
            {
                label: "Accumulated amount (Inspection)",
                fill: false,
                borderColor: "yellow",
                backgroundColor:"yellow",
                pointFillColor: "yellow",
                steppedLine:false,
                pointHoverBorderColor: "yellow",
                pointRadius:5,
                data: padChartData(chartLabels,inspectionChartValues)
            },   
            ]
        },
        options: {
            legend: { display: true },
            title: {
            display: true,
            text: 'Cost of all owned vehicles per month of the last 12 months'

            }
        }
    });

    </script>

    <hr class="my-4">
    <div class="container">

        <div class="row" style="margin-top:5%;">
            <h4>
                @php echo last_used_by($car); @endphp
            </h4>
            <!-- TODO does nothing currently -->
        </div>

        <div class="row" style="margin-bottom: 5%;">
            <div class="col-auto">
                @if (strpos(last_used_by($car), 'available') || strpos(last_used_by($car), 'Last used by'))
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignDriverModal">Assign new driver</button>
                @else
                <form action="{{route('cardriver.destroy', $car->carDriver->sortByDesc('end_date')->first())}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger">Remove driver</button>
                </form>
                @endif
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="/car/{{$car->id}}/history">Driver history</a>
            </div>
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

    <div class="row vehicleEvents">
        @include('partials.vehicleEvent', ['route_name' => 'maintenance', 'events' => $car->maintenances, 'eventDate' => $maintenanceDate])

        @include('partials.vehicleEvent', ['route_name' => 'insurance', 'events' => $car->insurances, 'eventDate' => $insuranceDate])

        @include('partials.vehicleEvent', ['route_name' => 'tax', 'events' => $car->taxes, 'eventDate' => $taxDate])

        @include('partials.vehicleEvent', ['route_name' => 'inspection', 'events' => $car->inspections, 'eventDate' => $inspectionDate])
    </div>

    <div class="row justify-content-end" style="margin-top:10%;">

        <div class="col col-md-auto">
            <a href="{{route('alerts', ['id' => $car->id])}}" class="btn btn-primary">Settings</a>


        </div>
        <!-- TODO does not work currently -->
        <div class="col col-md-auto">
            <button type="button" class="btn btn-danger">Delete car</button>
        </div>

    </div>

</div>


@endsection
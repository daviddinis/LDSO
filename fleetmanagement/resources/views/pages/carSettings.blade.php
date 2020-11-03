@extends('layouts.app')

@section('title', 'EditCarAlerts')

@section('styles')
<link href="{{ asset('css/carAlerts.css') }}" rel="stylesheet">
@endsection
@section('scripts')
<script src="{{ asset('js/openAlertMenu.js') }}" rel="stylesheet" defer></script>
@endsection
@php
//array whose keys are the alert type and whose values are the respective alert time in days
$alertTimez = array('Yellow' => $car->yellow_alert, 'Red' => $car->red_alert, 'Overdue' => 0);

//returns alert date string in format Y-m-d
//$eventdate -> event date, $alertTolerance -> alert time in days (date used to notify x days before the event)
function eventDate($eventDate, $alertTolerance){

$dateTime = new DateTime($eventDate);
$alertInterval = new DateInterval("P" . $alertTolerance . "D");
$alertDateTime = new DateTime($eventDate);
$alertDateTime->sub($alertInterval);


return $alertDateTime->format('Y-m-d');
}

//returns string in the following format: "x days" - number of days till date (-x days if the day has passed)
function timeToEvent($currentDate, $eventDate, $alertTolerance){

$dateTime = new DateTime($currentDate);
$alertDateTime = new DateTime(eventDate($eventDate, $alertTolerance));


$alertDateInterval = date_diff($dateTime, $alertDateTime);

return $alertDateInterval->format('%r%a days');

}


function currentTimeToEvent($eventDate, $alertTolerance){
return timeToEvent(date("Y-m-d"), $eventDate, $alertTolerance);
}
@endphp

@section('content')

<div class="jumbotron carSettingsSection">

    <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{route('car.show', ['id' => $car->id])}}">
                <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
            </a></li>

        <li class="breadcrumb-item active">Alerts</li>
    </ol>

    <div class="container">
        <div class="row">
            <div class="col-auto mr-auto">
                <h1 class="display-3">{{$car->make}} {{$car->model}} </h1>
                <br>
                <p>{{$car->license_plate}}</p>
                <br>
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

        <div class="row justify-content-center align-items-center" style="margin-bottom:5%;">

            <div class="col-12 alerts-header">Alerts</div>
        </div>

        <div id="alert-button-div" style="margin-top:5%; margin-bottom:5%;">

            <div class="dropdown">
                <button id="alerts-edit-button" class="dropbtn btn btn-primary" style="min-width: 200px;">
                    Edit Alerts
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <form id="alerts-form" class="dropdown-item" action="{{route('editAlerts', ['id' => $car->id])}}" method="post">
                        {{ csrf_field() }}

                        <div class="yellow-alert-segment">
                            <label for="yellow-input">Yellow Alert:</label>
                            <div class="form-group">
                                <input id="yellow-input" name="yellow" type="number" value="{{$car->yellow_alert}}" min="{{$car->red_alert + 1}}" max="365" step="1" required>days
                            </div>
                        </div>


                        <div class="red-alert-segment">
                            <label for="red-input">Red Alert:</label>

                            <div class="form-group">
                                <input id="red-input" name="red" type="number" value="{{$car->red_alert}}" min="1" max="{{$car->yellow_alert - 1}}" step="1" required>days
                            </div>
                        </div>


                        {{-- <div class="row justify-content-end"><input class="btn btn-primary col-5" type="submit" value="Submit"></div> --}}
                    </form>
                </div>
            </div>

        </div>




        @include('partials.alertCards')

        <div class="row justify-content-end mr-xl-3">
             <div class="col-auto col-md-auto">
                 <input type="submit" class="btn btn-primary" form="alerts-form" value="Save Changes" />
             </div>
        </div>



    </div>
</div>


@endsection


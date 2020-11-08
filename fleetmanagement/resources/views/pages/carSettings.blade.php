@extends('layouts.app')

@section('title', 'Car Settings')

@section('styles')
<link href="{{ asset('css/carAlerts.css') }}" rel="stylesheet">
@endsection
@section('scripts')
<script src="{{ asset('js/openAlertMenu.js') }}" rel="stylesheet" defer></script>
@endsection
@php
//array whose keys are the alert type and whose values are the respective alert time in days
$alertTimez = array('Yellow' => $car->yellow_alert, 'Red' => $car->red_alert, 'Overdue' => 0);
$max_alert_time = 365;
$red_position_percentage = $car->red_alert / $max_alert_time * 100;
$yellow_position_percentage = $car->yellow_alert / $max_alert_time * 100;




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
        <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
            </a></li>

        <li class="breadcrumb-item active">Settings</li>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAlertsModal">Edit Alerts</button>
        </div>

        <div id="editAlertsModal" class="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Car Alerts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="alerts-form" action="{{route('editAlerts', ['id' => $car->id])}}" method="post">
                            {{ csrf_field() }}

                            <p style="font-size=.825rem;">Yellow and Red Alert's Times</p>
                            <p>(number of days before being overdue)</p>

                            <div slider id="slider-distance">
                                
                                <div>
                                    <div inverse-left style="width:{{$red_position_percentage}}%;"></div>
                                    <div inverse-right style="width:{{100 - $yellow_position_percentage}}%;"></div>
                                    <div range style="left:{{$red_position_percentage}}%;right:{{100 - $yellow_position_percentage}}%;"></div>




                                    <span thumb style="left:{{$red_position_percentage}}%;"></span>
                                    <span thumb style="left:{{$yellow_position_percentage}}%;"></span>


                                    <div id="r-sign" sign style="left:{{$red_position_percentage-2}}%;">

                                        <span id="value">{{$car->red_alert}}</span>
                                    </div>
                                    <div id="y-sign" sign style="left:{{$yellow_position_percentage}}%;">

                                        <span id="value">{{$car->yellow_alert}}</span>

                                    </div>
                                </div>
                                <input id="r-input" name="red" type="range" value="{{$car->red_alert}}" max="{{$max_alert_time}}" min="1" step="1" />

                                <input id="y-input" name="yellow" type="range" value="{{$car->yellow_alert}}" max="{{$max_alert_time}}" min="1" step="1" />

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" form="alerts-form" value="Save Changes" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Preview</button>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.alertCards')

    </div>
</div>


@endsection


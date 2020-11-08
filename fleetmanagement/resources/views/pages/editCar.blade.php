@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-md">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%" id="carSettingsTitle">
                <h1>Settings</h1>
        </div>
        
        <div class="row" id="carCards">
            <div class="col">
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
                <div class="col col-md-auto" id="settingsEditButton">
                    <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/settings" >Edit</a></button>
                </div>
            </div>
            <div class="col">
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
                <div class="col col-md-auto" id="settingsEditButton">
                    <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/settings" >Edit</a></button>
                </div>
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
                <div class="col col-md-auto" id="settingsEditButton">
                    <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/settings/taxes" >Edit</a></button>
                </div>
            </div>
            <div class="col">
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
                <div class="col col-md-auto" id="settingsEditButton">
                    <button class="btn btn-primary"><a class="button" href="/car/{{$car->id}}/settings" >Edit</a></button>
                </div>
            </div>
        </div>

</div>
@endsection

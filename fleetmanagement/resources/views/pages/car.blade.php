@extends('layouts.app')

@section('title', 'Car')

@section('content')
<h1>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</h1>
<h2>Total cost:
    @php
    // Function to add all costs from each category (tax, inspection, etc.)
    function sum_costs($arr){
        $total = 0;
        foreach ($arr as $obj) {
            $total += $obj['value'];
        }
        return $total;
    }
    echo sum_costs($car->taxes) + sum_costs($car->maintenances) + sum_costs($car->inspections) + sum_costs($car->insurances);
    @endphp
    €
</h2>

{{-- Section to display current driver, if available --}}
<h2>
@php
    $last_driver = $car->drivers->first();
    if($last_driver != null){ // there is a driver
        $dates = $last_driver->pivot;

        if($dates->end_date != null){
            if(date($dates->end_date) < date('Y-m-d'))
                echo 'Last used by ' . $last_driver->name . ' from ' . $dates->start_date . ' until ' . $dates->end_date;
            else
                echo 'In use by ' . $last_driver->name . ' from ' . $dates->start_date . ' until ' . $dates->end_date;
        }
        else
        {
            echo 'In use by ' . $last_driver->name . ' from ' . $dates->start_date;
        }
    }
@endphp
</h2>

<h2>History</h2>
<h3>Maintenances: <br>Total: {{count($car->maintenances)}} @if(count($car->maintenances))<br>Latest - {{$car->maintenances->first()->date}}@endif</h3>
<h3>Insurances: <br>Total: {{count($car->insurances)}} @if(count($car->insurances))<br>Latest - {{$car->insurances->first()->date}}@endif</h3>
<h3>Taxes: <br>Total: {{count($car->taxes)}} @if(count($car->taxes))<br>Latest - {{$car->taxes->first()->date}}@endif</h3>
<h3>Inspections: <br>Total: {{count($car->inspections)}} @if(count($car->inspections))<br>Latest - {{$car->inspections->first()->date}}@endif</h3>
@endsection

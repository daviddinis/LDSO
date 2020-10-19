@extends('layouts.app')

@section('title', 'Car')

@section('content')
<h1>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</h1>
<h2>Total cost:
    @php
    function sum_costs($arr){
        $total = 0;
        foreach ($arr as $tax) {
            $total += $tax['value'];
        }
        return $total;
    }
    echo sum_costs($car->taxes) + sum_costs($car->maintenances) + sum_costs($car->inspections) + sum_costs($car->insurances);
    @endphp
    €
</h2>
<h4>Maintenances: {{$car->maintenances}}</h4>
<h4>Insurances: {{$car->insurances}}</h4>
<h4>Taxes: {{$car->taxes}}</h4>
<h4>Inspections: {{$car->inspections}}</h4>
@endsection

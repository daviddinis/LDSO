@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')

<section id="history" class="d-flex flex-wrap justify-content-around align-content-around mt-5">
                @foreach ($cars as $car)
                    <div class="card mb-3 w-100">
                    <div class="card-header">
                        <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
                    </div>
                    <div class="card-body">
                    <table class="table table-hover">
                    @foreach ($maintenances as $maintenance)
                            @if($car->id == $maintenance->car_id)
                                <thead>
                                    <tr>
                                        <th scope="col">TYPE</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Mileage</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Next Maintenance</th>
                                        <th scope="col">Observations</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                @break
                             @endif
                    @endforeach
                    @foreach ($maintenances as $maintenance)
                            @if($car->id == $maintenance->car_id)
                            <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> maintenance </th>
                                    <td>{{$maintenance->id}}</td>
                                    <td>{{$maintenance->date}}</td>
                                    <td>{{$maintenance->kilometers}} Km</td>
                                    <td>{{$maintenance->value}}€</td>
                                    <td>@if($maintenance->next_maintenance_date != null){{$maintenance->next_maintenance_date}} @else N/A @endif</td>
                                    <td>@if($maintenance->obs != null){{$maintenance->obs}} @else N/A @endif</td>
                                    <td>@if($maintenance->file != null) <a href="{{ asset($maintenance->file) }}" style="color: white" download="{{substr($maintenance->file, 17)}}">Download File</a> @else N/A @endif </td>
                                </tr>
                                </tbody>
                            @endif
                    @endforeach
                    @foreach ($insurances as $insurance)
                            @if($car->id == $insurance->car_id)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">TYPE</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Expiration date</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Observations</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                @break
                             @endif
                    @endforeach
                    @foreach ($insurances as $insurance)
                            @if($car->id == $insurance->car_id)
                                <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> insurance </th>
                                    <td>{{$insurance->id}}</td>
                                    <td>{{$insurance->date}}</td>
                                    <td>{{$insurance->expiration_date}}</td>
                                    <td>{{$insurance->value}}€</td>
                                    <td>@if($insurance->obs != null){{$insurance->obs}} @else N/A @endif</td>
                                    <td>@if($insurance->file != null) <a href="{{ asset($insurance->file) }}" style="color: white" download="{{substr($insurance->file, 17)}}">Download File</a> @else N/A @endif </td>
                                </tr>
                                </tbody>
                            @endif
                    @endforeach
                    @foreach ($inspections as $inspection)
                            @if($car->id == $inspection->car_id)
                                <thead>
                                    <tr>
                                        <th scope="col">TYPE</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Expiration date</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Observations</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                @break
                             @endif
                    @endforeach
                    @foreach ($inspections as $inspection)
                            @if($car->id == $inspection->car_id)
                            <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> inspection </th>
                                    <td>{{$inspection->id}}</td>
                                    <td>{{$inspection->date}}</td>
                                    <td>{{$inspection->expiration_date}}</td>
                                    <td>{{$inspection->value}}€</td>
                                    <td>@if($inspection->obs != null){{$inspection->obs}} @else N/A @endif</td>
                                    <td>@if($inspection->file != null) <a href="{{ asset($inspection->file) }}" style="color: white" download="{{substr($inspection->file, 17)}}">Download File</a> @else N/A @endif </td>
                                </tr>
                                </tbody>
                            @endif
                    @endforeach
                    @foreach ($taxes as $tax)
                            @if($car->id == $tax->car_id)
                                <thead>
                                    <tr>
                                        <th scope="col">TYPE</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Expiration Date</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Observations</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                @break
                             @endif
                    @endforeach
                    @foreach ($taxes as $tax)
                            @if($car->id == $tax->car_id)
                            <tbody>
                                <tr class="table-primary">
                                   <th scope="row">tax</th>
                                    <td>{{$tax->id}}</td>
                                    <td>{{$tax->date}}</td>
                                    <td>{{$tax->expiration_date}}</td>
                                    <td>{{$tax->value}}€</td>
                                    <td>@if($tax->obs != null){{$tax->obs}} @else N/A @endif</td>
                                    <td>@if($tax->file != null) <a href="{{ asset($tax->file) }}" style="color: white" download="{{substr($tax->file, 9)}}">Download File</a> @else N/A @endif </td>
                                </tr>
                                </tbody>
                            @endif
                    @endforeach
                    </table>
                    </div>     
                </div>    
                @endforeach
    </div>

@endsection

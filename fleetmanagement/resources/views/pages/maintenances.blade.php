@extends('layouts.app')

@section('content')

    <div class="jumbotron" style="padding-top: 3%">
        <ol class="breadcrumb" style="border-width: 0">
            <li class="breadcrumb-item"><a href="{{route('car.show', $car->id)}}">
                    <p>{{$car->make}} {{$car->model}} - {{$car->license_plate}}</p>
                </a></li>

            <li class="breadcrumb-item active">Maintenances</li>
        </ol>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Mileage</th>
                    <th scope="col">Value</th>
                    <th scope="col">Next Maintenance</th>
                    <th scope="col">Observations</th>
                    <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintenances as $maintenance)
                <tr class="table-primary">
                    <th scope="row">{{$maintenance->id}}</th>
                    <td>{{$maintenance->date}}</td>
                    <td>{{$maintenance->kilometers}} Km</td>
                    <td>{{$maintenance->value}}€</td>
                    <td>@if($maintenance->next_maintenance_date != null){{$maintenance->next_maintenance_date}} @else N/A @endif</td>
                    <td>@if($maintenance->obs != null){{$maintenance->obs}} @else N/A @endif</td>
                    <td>@if($maintenance->file != null){{$maintenance->file}} @else N/A @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
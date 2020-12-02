@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')

<section id="history" class="d-flex flex-wrap justify-content-around align-content-around mt-5">
                @foreach ($cars as $car)
                    @foreach ($history as $carhistory)
                            @if($car->id == $carhistory->car_id)
                            <div class="card mb-3 w-100">
                            <div class="card-header">
                                <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }} {{ $car->license_plate }}</a>
                            </div>
                            <div class="card-body">
                            <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">TYPE</th>
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
                    @foreach ($history as $carhistory)
                            @if($car->id == $carhistory->car_id)
                            <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> {{$carhistory->type}} </th>
                                    <td>{{$carhistory->date}}</td>
                                    <td>@if($carhistory->next_maintenance_date != null){{$carhistory->next_maintenance_date}} @else N/A @endif</td>
                                    <td>{{$carhistory->value}}€</td>
                                    <td>@if($carhistory->obs != null){{$carhistory->obs}} @else N/A @endif</td>
                                    <td>@if($carhistory->file != null) <a href="{{ asset($carhistory->file) }}" style="color: white" download="{{substr($carhistory->file, 17)}}">Download File</a> @else N/A @endif </td>
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

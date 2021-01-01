@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')

<section id="history" >
<div class="d-flex justify-content-between my-2 ">
    
    <div class="container">
      <div class="row">
        <h2 class="">History </h2>
      </div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#cost">All History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#maintenances">Maintenances History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#taxes">Taxes History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#hide">Don't show</a>
          </li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active show" id="cost">
          @foreach ($cars as $car)
            @foreach ($history as $carhistory)
              @if($car->id == $carhistory->car_id)
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
              @break
              @endif 
            @endforeach
          @endforeach
    </div>
    <div class="tab-pane fade" id="maintenances">  
    
      <div class="card-body">
        <table class="table table-hover">
              <thead>
                  <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Car Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Next Maintenance date</th>
                      <th scope="col">km</th>
                      <th scope="col">Value</th>
                      <th scope="col">Observations</th>
                      <th scope="col">File</th>
                  </tr>
              </thead>
              @foreach ($allMaintenances as $maintenance)
              <tbody>
                  <tr class="table-primary">
                      <th scope="row"> {{$maintenance->id}} </th>
                      @foreach ($cars as $car)
                      @if($car->id == $maintenance->car_id)
                      <td>{{ $car->make }} {{ $car->model }} {{ $car->license_plate }}</td>
                      @endif
                      @endforeach
                      <td>{{$maintenance->date}}</td>
                      <td>@if($maintenance->next_maintenance_date != null){{$maintenance->next_maintenance_date}} @else N/A @endif</td>
                      <td>{{$maintenance->kilometers}} km</td>
                      <td>{{$maintenance->value}} €</td>
                      <td>@if($maintenance->obs != null){{$maintenance->obs}} @else N/A @endif</td>
                      <td>@if($maintenance->file != null) <a href="{{ asset($maintenance->file) }}" style="color: white" download="{{substr($maintenance->file, 17)}}">Download File</a> @else N/A @endif </td>
                  </tr>
              </tbody>
              @endforeach
        </table>
      </div> 
    
  </div>
  <div class="tab-pane fade" id="taxes">
    <p>Taxes history!</p>  
  </div>
  <div class="tab-pane fade" id="hide">
  </div>
</div>

@endsection



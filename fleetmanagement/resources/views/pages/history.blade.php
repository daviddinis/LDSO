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
        <table id="maintenancesTable" class="table table-hover">
              <thead>
                  <tr>
                      <th scope="col"><a href="#" onclick="sortTable(0)">ID</a></th>
                      <th scope="col"><a href="#" onclick="sortTable(1)">Car Name</a></th>
                      <th scope="col"><a href="#" onclick="sortTable(2)">Date</a></th>
                      <th scope="col"><a href="#" onclick="sortTable(3)">Next Maintenance date</a></th>
                      <th scope="col"><a href="#" onclick="sortTable(4)">km</a></th>
                      <th scope="col"><a href="#" onclick="sortTable(5)">Value</a></th>
                      <th scope="col"><a href="#">Observations</a></th>
                      <th scope="col"><a href="#">File</a></th>
                  </tr>
              </thead>
              @foreach ($allMaintenances as $maintenance)
              <tbody>
                  <tr class="table-primary">
                      <th scope="row"><span class="maintenanceID">{{$maintenance->id}}</span></th>
                      @foreach ($cars as $car)
                      @if($car->id == $maintenance->car_id)
                      <td><span class="carName">{{ $car->make }} {{ $car->model }} {{ $car->license_plate }}</span></td>
                      @endif
                      @endforeach
                      <td><span class="maintenanceDate">{{$maintenance->date}}</span></td>
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

{{-- <button onclick="sortTable()">Muerder me</button> --}}
<script>
var sort = [0,0,0,0,0,0];
function sortTable(option) {
    if(sort[option] == 0)
        sortAsc(option);
    else
        sortDesc(option);
}
function sortAsc(option){
  sort[option] = 1;
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("maintenancesTable");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    var isnumber = false;
    var isword = false;
    var isdate = false;

    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        
        if(option == 0) {
            x = document.getElementsByClassName("maintenanceID")[i-1];
            y = document.getElementsByClassName("maintenanceID")[i];
            isnumber = true;
        }
        else if(option == 1) {
            x = document.getElementsByClassName("carName")[i-1];
            y = document.getElementsByClassName("carName")[i];
            isword = true;
        }
        else if(option == 2) {
            x = document.getElementsByClassName("maintenanceDate")[i-1];
            y = document.getElementsByClassName("maintenanceDate")[i];
            isdate = true;
        }

        if(isnumber){
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
                shouldSwitch = true;
                break;
            }
        }
        else if (isword){
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        else if (isdate){
            if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
    
  }
}
function sortDesc(option){
  sort[option] = 0;

    var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("maintenancesTable");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    var isnumber = false;
    var isword = false;
    var isdate = false;

    for (i = 1; i < (rows.length - 1); i++) {

        shouldSwitch = false;
        if(option == 0) {
            x = document.getElementsByClassName("maintenanceID")[i-1];
            y = document.getElementsByClassName("maintenanceID")[i];
            isnumber = true;
        }
        else if(option == 1) {
            x = document.getElementsByClassName("carName")[i-1];
            y = document.getElementsByClassName("carName")[i];
            isword = true;
        } 
        else if(option == 2) {
            x = document.getElementsByClassName("maintenanceDate")[i-1];
            y = document.getElementsByClassName("maintenanceDate")[i];
            isdate = true;
        } 
        if(isnumber){
            if (Number(x.innerHTML) < Number(y.innerHTML)) {
                shouldSwitch = true;
                break;
            }
        }
        else if (isword){
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        else if (isdate){
            if (x.innerHTML < y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

@endsection



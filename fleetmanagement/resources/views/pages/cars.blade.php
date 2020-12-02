@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')

<section id="cars">
    <div class="d-flex justify-content-between my-2 ">
        <h2 class="">Dashboard </h2><button onclick="gridViewToggle()"class="btn btn-outline-primary" ><i class="fa fa-list p-1" id="gridViewToggle" ></i></button>
    </div>
    <div class="d-none" id="gridView">
        <div class="d-flex flex-wrap justify-content-around align-content-around ">
            @each('partials.carGrid', $cars, 'car')
        </div>
    </div>
    <div class="" id="listView">
        <table id="carTable" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><a href="#" onclick="sortTable(0)">Model</a></th>
                    <th scope="col"><a href="#" onclick="sortTable(1)"> License Plate</a></th>
                    <th scope="col"><a href="#" onclick="sortTable(2)">Issues</a></th>
                    <th scope="col"><a href="#" onclick="sortTable(3)">Current Driver</a></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @each('partials.carList', $cars, 'car')
            </tbody>
        </table>
    </div>
    {{-- <button onclick="sortTable()">Muerder me</button> --}}
<script>
var sort = [0,0,0,0];
function sortTable(option) {
    if(sort[option] == 0)
        sortAsc(option);
    else
        sortDesc(option);
}
function sortAsc(option){
  sort[option] = 1;
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("carTable");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;


    for (i = 1; i < (rows.length - 1); i++) {

        shouldSwitch = false;

      if(option == 0) {
        x = document.getElementsByClassName("carLink")[i-1];
        y = document.getElementsByClassName("carLink")[i];
      } else if(option == 2){
        x = document.getElementsByClassName("carBadge")[i-1];
        y = document.getElementsByClassName("carBadge")[i];
      } else {
        x = rows[i].getElementsByTagName("TD")[option];
        y = rows[i +1].getElementsByTagName("TD")[option];
    }
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        shouldSwitch = true;
        break;
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
  table = document.getElementById("carTable");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;


    for (i = 1; i < (rows.length - 1); i++) {

        shouldSwitch = false;

      if(option == 0) {
        x = document.getElementsByClassName("carLink")[i-1];
        y = document.getElementsByClassName("carLink")[i];
      } else if(option == 2){
        x = document.getElementsByClassName("carBadge")[i-1];
        y = document.getElementsByClassName("carBadge")[i];
      } else {
        x = rows[i].getElementsByTagName("TD")[option];
        y = rows[i +1].getElementsByTagName("TD")[option];
    }
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

</section>
<a href="/car/create" class="btn btn-primary btn-lg rounded-circle " style="position:fixed;bottom:30px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection

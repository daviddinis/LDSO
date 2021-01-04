@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')


<section id="cars">
  <div class="d-flex justify-content-between my-2 ">
      
    <div class="container">
      <div class="row">
        <h2 class="">Statistics </h2>
      </div>
      <div class="row">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#cost">Cost</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#mileage">Mileage</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#issues">Issues</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#hide">Don't show</a>
          </li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active show" id="cost">
            <canvas id="cost-chart" width="1080px" height="420"></canvas>
          </div>
          <div class="tab-pane fade" id="mileage">            
            <!-- Put another graph here! -->
            <p>Put another graph here!</p>
          </div>
          <div class="tab-pane fade" id="issues">
            <!-- Put another graph here! -->
            {{-- ONLY WORKS WITH THIS DIV AND ONLY IF IT HAS DIMENSIONS --}}
            <div style="height:420px; width:1080px;"> 
            <canvas id="issues-chart" width="1080px" height="420px"></canvas>
            </div>
          </div>
          <div class="tab-pane fade" id="hide">
            <!-- Don't put anything here :) -->
          </div>
        </div>
      </div>
      <hr class="my-4">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

        <script>
        
        // Use to pad chart data with nulls so lines render properly
        function padChartData(labels, data)
        {
          const filledMonths = data.map((month) => month.x);
          const dataset = labels.map(month => {
            const indexOfFilledData = filledMonths.indexOf(month);
            if( indexOfFilledData!== -1) return data[indexOfFilledData].y;
            return null;
          });
          return dataset;
        }

        var chartLabels = @php echo $graphLabels; @endphp;
        var maintenanceChartValues = @php echo $maintenanceValues; @endphp;
        var taxChartValues = @php echo $taxValues; @endphp;
        var insuranceChartValues = @php echo $insuranceValues; @endphp;
        var inspectionChartValues = @php echo $inspectionValues; @endphp;

        // Multiple line chart for car cost
        new Chart(document.getElementById("cost-chart"), {
            type: 'line',
            data: {
              labels: chartLabels,
              datasets: [               
                {
                  label: "Accumulated amount (Maintenance)",
                  fill: false,
                  borderColor: "red",
                  pointBackgroundColor:"red",
                  pointFillColor: "red",
                  steppedLine:false,
                  pointHoverBorderColor: "red",
                  pointRadius:5,
                  data: padChartData(chartLabels,maintenanceChartValues)
                },   
                {
                  label: "Accumulated amount (Tax)",
                  fill: false,
                  borderColor: "green",
                  pointBackgroundColor:"green",
                  pointFillColor: "green",
                  steppedLine:false,
                  pointHoverBorderColor: "green",
                  pointRadius:5,
                  data: padChartData(chartLabels,taxChartValues)
                },   
                {
                  label: "Accumulated amount (Insurance)",
                  fill: false,
                  borderColor: "blue",
                  pointBackgroundColor:"blue",
                  pointFillColor: "blue",
                  steppedLine:false,
                  pointHoverBorderColor: "blue",
                  pointRadius:5,
                  data: padChartData(chartLabels,insuranceChartValues)
                },   
                {
                  label: "Accumulated amount (Inspection)",
                  fill: false,
                  borderColor: "yellow",
                  pointBackgroundColor:"yellow",
                  pointFillColor: "yellow",
                  steppedLine:false,
                  pointHoverBorderColor: "yellow",
                  pointRadius:5,
                  data: padChartData(chartLabels,inspectionChartValues)
                },   
              ]
            },
            options: {
              legend: { display: true },
              title: {
                display: true,
                text: 'Cost of all owned vehicles per month of the last 12 months'

              }
            }
        });

        let issuesChartValues = @php echo $issuesChartValues; @endphp;

        let oi = new Chart(document.getElementById("issues-chart"), {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "Accumulated Issues (All)",
                        fill: false,
                        borderColor: "orange",
                        backgroundColor: "orange",
                        pointFillColor: "orange",
                        steppedLine: false,
                        pointHoverBorderColor: "orange",
                        pointRadius: 2,
                        data: padChartData(chartLabels, issuesChartValues)
                    },
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Recorded usage of vehicle per month of the last 12 months'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0
                        }
                    }],
                },

            }
        });
        </script>



  </div>
  </div>


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
    <hr class="my-4">
    <div>{{$cars->links()}}</div>
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
            witching = true;
        }
    }
}
</script>

</section>
<a href="/car/create" class="btn btn-primary btn-lg rounded-circle " style="position:fixed;bottom:30px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection

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
                        <div style="display: block; height:420px; width:1080px">
                            <canvas id="mileage-chart" ></canvas>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="issues">

                        <!-- Put another graph here! -->
                        <p>Put another graph here!</p>
                    </div>
                    <div class="tab-pane fade" id="hide">
                        <!-- Don't put anything here :) -->
                    </div>
                </div>
            </div>
            <hr class="my-4">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

            <script>
                function padChartData(labels, data) {
                    const filledMonths = data.map((month) => month.x);
                    const dataset = labels.map(month => {
                        const indexOfFilledData = filledMonths.indexOf(month);
                        if (indexOfFilledData !== -1) return data[indexOfFilledData].y;
                        return null;
                    });
                    return dataset;
                }


                var chartLabels = @php echo $graphLabels;
                @endphp;
                var maintenanceChartValues = @php echo $maintenanceValues;
                @endphp;
                var taxChartValues = @php echo $taxValues;
                @endphp;
                var insuranceChartValues = @php echo $insuranceValues;
                @endphp;
                var inspectionChartValues = @php echo $inspectionValues;
                @endphp;
                var mileageChartValues = @php echo $mileage;
                @endphp;



                new Chart(document.getElementById("mileage-chart").getContext("2d"), {
                    type: 'line'
                    , data: {
                        labels: chartLabels
                        , datasets: [{
                            label: "Accumulated amount (Mileage)"
                            , fill: false
                            , borderColor: "red"
                            , pointBackgroundColor: "red"
                            , pointFillColor: "red"
                            , steppedLine: false
                            , pointHoverBorderColor: "red"
                            , pointRadius: 5
                            , data: padChartData(chartLabels, mileageChartValues)
                        }]
                    }
                    , options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      legend: {
                            display: false
                        }
                        , title: {
                            display: true
                            , text: 'Cost of all owned vehicles per month of the last 12 months'

                        }
                    }
                });


                // Multiple line chart for car cost
                new Chart(document.getElementById("cost-chart"), {
                    type: 'line'
                    , data: {
                        labels: chartLabels
                        , datasets: [{
                                label: "Accumulated amount (Maintenance)"
                                , fill: false
                                , borderColor: "red"
                                , pointBackgroundColor: "red"
                                , pointFillColor: "red"
                                , steppedLine: false
                                , pointHoverBorderColor: "red"
                                , pointRadius: 5
                                , data: padChartData(chartLabels, maintenanceChartValues)
                            }
                            , {
                                label: "Accumulated amount (Tax)"
                                , fill: false
                                , borderColor: "green"
                                , pointBackgroundColor: "green"
                                , pointFillColor: "green"
                                , steppedLine: false
                                , pointHoverBorderColor: "green"
                                , pointRadius: 5
                                , data: padChartData(chartLabels, taxChartValues)
                            }
                            , {
                                label: "Accumulated amount (Insurance)"
                                , fill: false
                                , borderColor: "blue"
                                , pointBackgroundColor: "blue"
                                , pointFillColor: "blue"
                                , steppedLine: false
                                , pointHoverBorderColor: "blue"
                                , pointRadius: 5
                                , data: padChartData(chartLabels, insuranceChartValues)
                            }
                            , {
                                label: "Accumulated amount (Inspection)"
                                , fill: false
                                , borderColor: "yellow"
                                , pointBackgroundColor: "yellow"
                                , pointFillColor: "yellow"
                                , steppedLine: false
                                , pointHoverBorderColor: "yellow"
                                , pointRadius: 5
                                , data: padChartData(chartLabels, inspectionChartValues)
                            }
                        , ]
                    }
                    , options: {
                        legend: {
                            display: true
                        }
                        , title: {
                            display: true
                            , text: 'Cost of all owned vehicles per month of the last 12 months'

                        }
                    }
                });

            </script>



        </div>
    </div>


    <div class="d-flex justify-content-between my-2 ">
        <h2 class="">Dashboard </h2><button onclick="gridViewToggle()" class="btn btn-outline-primary"><i class="fa fa-list p-1" id="gridViewToggle"></i></button>
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

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("carTable");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            if (n == 0) {
                x = document.getElementsByClassName("carLink")[i - 1];
                y = document.getElementsByClassName("carLink")[i];
            } else if (n == 2) {
                x = document.getElementsByClassName("carBadge")[i - 1];
                y = document.getElementsByClassName("carBadge")[i];
            } else {
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
            }
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
</script>

</section>
<a href="/car/create" class="btn btn-primary btn-lg rounded-circle " style="position:fixed;bottom:30px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection

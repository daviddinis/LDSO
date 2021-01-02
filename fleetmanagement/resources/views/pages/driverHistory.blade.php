@extends('layouts.app')


@section('scripts')
<script src="{{ asset('js/driverChart.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')
<div class="d-flex justify-content-between my-2 ">
    <h2 class="">Driver List </h2>
</div>
<div class="container">
    <div class="row">
        <div class="col" style="margin-bottom:3em;">
            <canvas id="pie-chart" width="960px" height="300px"></canvas>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
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

    var driverChartLabels = @php echo $driverChartValues->pluck('x'); @endphp;
    var driverChartValues = @php echo $driverChartValues; @endphp;

    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
        labels: driverChartLabels,
        datasets: [
        {
            label: "Usage of vehicle by driver",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: padChartData(driverChartLabels, driverChartValues)
        }
        ]
        },
        options: {
        legend: { display: false },
        title: {
            display: true,
            text: 'Usage of vehicle (by driver)'
        }
        }
    });
</script>

<section id="drivers">
    <div class="" id="driverList">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">License</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                </tr>
            </thead>
            <tbody>
                @each('partials.driverHistoryList', $drivers, 'driver')
            </tbody>
        </table>
    </div>
    <div>{{$drivers->links()}}</div>


</section>
@endsection

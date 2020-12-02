<div class="card mb-3 w-100" style="max-width: 20rem;">

    <div class="card-header">
        <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
        <form style="float:right" method="post" action="{{route('car.destroy', $car->id)}}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle ">
                <i class="fa fa-trash"></i></button>
        </form>
    </div>
    <div class="card-body">
        {{ $car->license_plate }}
    </div>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item mr-auto">
            Issues
            @if($car->issues() == 0)
            <span class="badge badge-primary badge-pill">0</span>
            @elseif($car->issues() == 1)
            <span class="badge badge-warning badge-pill">1</span>
            @else
            <span class="badge badge-danger badge-pill">{{$car->issues()}}</span>
            @endif
        </li>
        <li class="list-group-item">@if(count($car->drivers) != null)
            {{$car->drivers->sortBy('end_date')->first()->name}}
        @else Available @endif</li>
    </ul>
</div>

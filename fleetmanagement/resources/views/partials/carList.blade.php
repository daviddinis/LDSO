@if($car->issues() == 0)
<tr class="">
    @elseif($car->issues() == 1)
<tr class="">
    @else
<tr class="">
    @endif
    <th scope="row"><a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a></th>
    <td>{{ $car->license_plate }}</td>
    <td>
        @if($car->issues() == 0)
        <span class="badge badge-primary badge-pill">0</span>
        @elseif($car->issues() == 1)
        <span class="badge badge-warning badge-pill">1</span>
        @else
        <span class="badge badge-danger badge-pill">{{$car->issues()}}</span>
        @endif</td>
    <td>{{$car->currentDriver()}}</td>
    <th>
        <form style="float:right" method="post" action="{{route('car.destroy', $car->id)}}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle ">
                <i class="fa fa-trash"></i></button>
        </form>
    </th>
</tr>


<!--
<div class="d-flex mb-3 w-100" style="max-width: 20rem;">

    <div class="">
        <form style="float:right" method="post" action="{{route('car.destroy', $car->id)}}" >
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle ">
            <i class="fa fa-trash"></i></button>
        </form>
    </div>
    <div class="">
        <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
        {{ $car->license_plate }}
    </div>
    <ul class="">
        <li class="">
            Issues
            <span class="badge badge-primary badge-pill ml-auto">
                @if($car->issues() == 0)
                <span>0</span>
                @elseif($car->issues() == 1)
                <span>1</span>
                @else
                <span>{{$car->issues()}}</span>
                @endif
            </span>
        </li>
        <li class="">{{$car->currentDriver()}}</li>
    </ul>
</div>
-->

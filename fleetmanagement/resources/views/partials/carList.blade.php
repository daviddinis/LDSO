</tr>
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


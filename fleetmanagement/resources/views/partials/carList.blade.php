
    <td scope="row"><a class="carLink" href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a></td>
    <td>{{ $car->license_plate }}</td>
    <td>
        @if($car->numIssues() == 0)
        <span class="carBadge badge badge-primary badge-pill">0</span>
        @elseif($car->numIssues() == 1)
        <span class="carBadge badge badge-warning badge-pill">1</span>
        @else
        <span class="carBadge badge badge-danger badge-pill">{{$car->numIssues()}}</span>
        @endif</td>
        {{-- TODO: fix the current driver display --}}
    <td>
        @if(count($car->drivers) != null)
            @php $lastDriver = $car->carDriver->sortByDesc('end_date')->first() @endphp  
            @php $driver = $car->drivers->sortByDesc('end_date')->first() @endphp  
            @if($lastDriver->end_date > \Carbon\Carbon::now())
                {{$lastDriver->driver->name}}
           @else Available (last used by {{$lastDriver->driver->name}}) @endif
        @else Available @endif
    </td>
    <th>
        <form style="float:right" method="post" action="{{route('car.destroy', $car->id)}}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle ">
                <i class="fa fa-trash"></i></button>
        </form>
    </th>
</tr>


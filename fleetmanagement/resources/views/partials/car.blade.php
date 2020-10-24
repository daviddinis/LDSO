<article class="card d-flex" data-id="{{ $car->id }}">
    <header>
        <h2>
            <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
            <br>{{ $car->license_plate }}<br>
            @foreach ($car->drivers as $driver)
            @if($driver->pivot['end_date'] === null || (!Carbon\Carbon::createFromFormat("!Y-m-d", $driver->pivot['end_date'])->isPast()))
                {{ $driver->name }}
            @endif
            @endforeach
        </h2>
    </header>
</article>

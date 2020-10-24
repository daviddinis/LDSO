<article class="card d-flex" data-id="{{ $car->id }}">
    <header>
        <h2>
            <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
            <br>{{ $car->license_plate }}<br>

        </h2>
    </header>
</article>

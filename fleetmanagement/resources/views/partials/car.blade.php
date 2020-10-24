<article class="card d-flex" data-id="{{ $car->id }}">
    <header>
        <h2>
            <a href="/car/{{ $car->id }}">{{ $car->make }} {{ $car->model }}</a>
            <br>{{ $car->license_plate }}<br>
            @if($car->issues() == 0)
            <span> no issues </span>
            @elseif($car->issues() == 1)
            <span> 1 issue </span>
            @else
            <span> {{$car->issues()}} issue </span>
            @endif
            {{$car->currentDriver()}}
        </h2>
    </header>
</article>

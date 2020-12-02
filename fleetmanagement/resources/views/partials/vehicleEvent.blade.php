{{-- ['route_name' => $route_name, 'events' => $car->inspections, 'eventDate' => $eventDate] --}}

@php
    $plural = 's';
    if ($route_name === 'tax')
        $plural = 'es';
    $eventInfo = getTypeAndTimeToEvent($car->yellow_alert, $car->red_alert, $eventDate);
    $typeColour = $eventInfo['typeColour'];
    $timerType = $eventInfo['timerType'];
    $alertTime = $eventInfo['time'];

@endphp

<div class="col-12 col-md-6 col-xl-3">
    <a href="{{route($route_name . '.find', $car->id)}}">
        <div class=" card text-white bg-primary mb-3" style="max-width: 40rem;">
            <div class="card-header">{{ ucfirst($route_name . $plural)}}</div>
            <div class="card-body">
                @if(count($events) !== 0)
                <h4 class="card-title">Total: {{count($events)}} @if(count($events))@endif</h4>
                <div class="card-text">
                    <p>Latest: {{$events->first()->date}}</p>
                    {{-- type -> alert type --}}
                    <div class="currentAlertTime {{$typeColour}}-segment">
                        @if($alertTime > 0)
                        <div>
                            {{abs($alertTime)}} days until {{$timerType}}
                        </div>       
                        @else
                        <div>
                            {{$timerType}} for {{abs($alertTime)}} days
                        </div>
                        @endif
                        {{-- <div class="time-value col-6 col-lg-6 col-xl-6 days{{$type}}"> --}}
                    </div>
                </div>

                @else
                <p class="card-text">No recorded<br>{{$route_name . $plural}}!</p>
                @endif
                
            </div>
        </div>
    </a>
</div>


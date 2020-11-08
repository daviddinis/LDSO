<div class="alertCard">
    <div class="card text-white bg-primary mb-3">
        {{-- category -> event category (example: maintenance) --}}
        <div class="card-header">{{$category}}</div>
        <div class="card-body">

            <h4 class="card-title">
                @if($eventDate!= null)
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">Overdue Date: </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">{{$eventDate}}</div>
                </div>
                @endif
            </h4>

            <div class="card-text row">
                {{-- type -> alert type --}}
                @if($eventDate!= null)
                @foreach($alertTimes as $type => $time)

                <div class="alertTimes col-12 col-sm-12	col-md-12 col-lg-12 col-xl-12">
                    <div class="alertTimeCategory row align-items-start">
                        <div class="time-type col-6 col-lg-6 col-xl-6">
                            {{$type}}
                        </div>
                        <div class="time-value col-6 col-lg-6 col-xl-6 days{{$type}}">

                            {{currentTimeToEvent($eventDate, $time)}}
                        </div>

                    </div>
                </div>
                @endforeach

                @else
                <p class="col-12">{{$category}} information isn't linked to this vehicle</p>
                @endif
            </div>
        </div>
    </div>
</div>


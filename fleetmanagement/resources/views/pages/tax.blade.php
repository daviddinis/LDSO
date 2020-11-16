@extends('layouts.app')

@section('content')
    <div class="jumbotron" style="padding-top: 3%">
        <ol class="breadcrumb" style="border-width: 0">
            <li class="breadcrumb-item"><a href="{{ route('car.show', $car->id) }}">
                    <p>{{ $car->make }} {{ $car->model }} - {{ $car->license_plate }}</p>
                </a></li>

            <li class="breadcrumb-item active">Taxes</li>
        </ol>
        <h3>Active tax</h3>


        <div class="card text-white bg-primary mb-3" style="margin: auto;">
            <div class="card-header">{{'Tax ID#: ' . $tax->id}}
                <form style="margin-left: 10px; float: right;" method="post"
                    action="{{ route('tax.destroy', [$car->id, $tax->id]) }}">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle "><i
                            class="fa fa-trash"></i></button>
                </form>

                <a href={{ route('tax.edit', [$car->id, $tax]) }} class="btn btn-info btn-sm rounded-circle"
                    style="float:right"><i class="fa fa-pencil"></i></a>
            </div>
            <div class="card-body">
                
                @if ($tax->file != null)
                    <button style="float:right;" type="button" class="btn btn-secondary">
                        <a href="{{ asset($tax->file) }}" style="color:black;"
                            download="{{ substr($tax->file, 9) }}">Download File</a>
                    </button>
                @endif
                <h1>{{$tax->obs}}</h1>
                    <ul class="list-group list-group-flush" style="margin-top:2%">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Acquired on</th>
                                    <th scope="col">Expires on</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Observations</th>
                                </tr>
                            </thead>

                            <tr class="table-primary">
                                <th scope="row">tax</th>
                                <th>{{ $tax->date }}</th>
                                <th>{{ $tax->expiration_date }}</th>
                                <th>{{ $tax->value . '€' }}</th>
                                <th>{{ $tax->obs }}</th>
                            </tr>
                        </table>
            </div>
        </div>
@endsection

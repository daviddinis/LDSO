@extends('layouts.app')


@section('scripts')
<script src="{{ asset('js/driverChart.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')
<div class="d-flex justify-content-between my-2 ">
    <h2 class="">Driver List </h2>
</div>
<section id="drivers">
    <div class="" id="driverList">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">License</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                </tr>
            </thead>
            <tbody>
                @each('partials.driverHistoryList', $drivers, 'driver')
            </tbody>
        </table>
    </div>



</section>
@endsection

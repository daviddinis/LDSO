@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')

<section id="cars">
    <div class="d-flex justify-content-between my-2 ">
        <h2 class="">Dashboard </h2><button onclick="gridViewToggle()"class="btn btn-outline-primary" ><i class="fa fa-list p-1" id="gridViewToggle" ></i></button>
    </div>
    <div class="d-none" id="gridView">
        <div class="d-flex flex-wrap justify-content-around align-content-around ">
            @each('partials.carGrid', $cars, 'car')
        </div>
    </div>
    <div class="" id="listView">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Model</th>
                    <th scope="col">License PLate</th>
                    <th scope="col">Issues</th>
                    <th scope="col">Current Driver</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @each('partials.carList', $cars, 'car')
            </tbody>
        </table>
    </div>


</section>
<a href="/car/create" class="btn btn-primary btn-lg rounded-circle " style="position:fixed;bottom:30px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection

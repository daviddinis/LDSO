@extends('layouts.app')

@section('content')

<section id="driver" class="d-flex flex-wrap justify-content-around align-content-around mt-5">

    @each('partials.driver', $drivers, 'driver')



</section> 
<div>{{$drivers->links()}}</div>

<a href="/driver/create" class="btn btn-primary btn-lg rounded-circle " style="position:absolute;bottom:30px;right:30px;">
    <i class="fa fa-plus"></i>
</a>

@endsection

@extends('layouts.app')

@section('content')

<section id="cars" class="d-flex flex-wrap justify-content-around align-content-around mt-5">

  @each('partials.car', $cars, 'car')


</section>

@endsection

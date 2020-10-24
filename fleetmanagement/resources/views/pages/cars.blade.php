@extends('layouts.app')

@section('content')

<section id="cars">

  @each('partials.car', $cars, 'car')


</section>

@endsection

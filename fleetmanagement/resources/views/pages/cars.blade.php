@extends('layouts.app')

@section('title', 'Cards')

@section('content')

<section id="cars">
  @each('partials.car', $cars, 'car')


</section>

@endsection

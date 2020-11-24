@extends('layouts.app')

@section('content')



@each('partials.driverHistoryList', $drivers, 'driver')

@endsection

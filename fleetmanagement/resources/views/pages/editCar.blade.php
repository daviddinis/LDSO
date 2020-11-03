@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-md">
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%" id="carSettingsTitle">
                <h1>Settings</h1>
        </div>
        
    </form>
</div>
@endsection

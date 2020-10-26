@extends('layouts.app')

@section('content')
<div class="container-md">
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

         <div class="row" style="margin-top: 5%">
            <div class="col-md-4"></div>
            <div class="col">
                <h1>Login</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <label for="name">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <label for="name">Password</label>
              <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>
        </div>
        <br>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-4"></div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h6>Don't have an account? <a href="{{route('register')}}">Register</a> now!</h6>
            </div>
        </div>
    </form>
</div>
@endsection

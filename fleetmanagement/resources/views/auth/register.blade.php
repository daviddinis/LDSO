@extends('layouts.app')

@section('content')
<div class="container-md">
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>Register</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="name">Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <label for="name">Company Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="company_name" name="company_name" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
              <label for="name">Password</label>
              <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>
            <div class="col-md-4">
              <label for="name">Confirm Password</label>
              <div class="input-group">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
              </div>
            </div>
        </div>
        <br>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg">Register</button>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom: 5%">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <h6>Already have an account? <a href="{{route('login')}}">Login</a> now!</h6>
            </div>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="title-register">
  <a> Company </a>
</div>

<div class="input-container">
  <form method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
      
      <div class="form-group">
        <label for="name">Company Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
          <span class="error">
              {{ $errors->first('name') }}
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="email">Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
          <span class="error">
              {{ $errors->first('email') }}
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="password">Country</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
          <span class="error">
              {{ $errors->first('password') }}
          </span>
        @endif
      </div>

      <!--<div class="form-group">
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>
      </div>-->

      <div class="title-register">
        <a> Vehicles </a>
      </div>

      <div class="subtitle-register">
        <a> Vehicle Number 1 </a>
      </div>

      <div class="form-group">
        <label for="name">Brand</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
          <span class="error">
              {{ $errors->first('name') }}
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="email">Model</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
          <span class="error">
              {{ $errors->first('email') }}
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="password">License Number</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
          <span class="error">
              {{ $errors->first('password') }}
          </span>
        @endif
      </div>

      <div class="add-button">
            <button type="submit"><img src="/icons/new.png" alt="Add button" class="fa fa-search" style="height:4em;width:4rem;margin-left:-0.3em;" ></img></button>
        </div>


      <button type="submit">
        Register
      </button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
  </form>
</div>
@endsection

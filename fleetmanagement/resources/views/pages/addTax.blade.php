@extends('layouts.app')

@section('content')
<div class="container-md">
    <form action={{ action('CarController@addTax') }} method="POST" id="add_tax_form">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 5%">
            <div class="col-md-2"></div>
            <div class="col">
                <h1>New Tax</h1>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="date">Date of the most recent tax</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="expiration_date">Expiration date of the tax</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="tax_value">Tax value</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tax_value" name="tax_value" required>
                </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-6">
              <label for="name">File</label>
              <div class="input-group">
                  <input type="file" class="form-control" id="file" name="file" required>
              </div>
            </div>
        </div>
        <br>
        <div class="row form-group">
            <div class="col-md-2"></div>
            <div class="col-md-6">
              <label for="obs">Observations</label>
              <div class="input-group">
                  <input type="text" class="form-control" id="obs" name="obs" required>
              </div>
            </div>
        </div>
        <br>
        <div class="container">
        <div class="row">
            <div class="col text-center" id="button-add-post">
                <button type="submit">  <a href="/car/{{$car->id}}/taxes/add" class="btn btn-primary" >Edit profile</a></button>
               
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
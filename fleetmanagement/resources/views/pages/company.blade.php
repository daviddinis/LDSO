@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')
<div class="container" style="padding-top: 3%">
    <button class="btn btn-secondary my-2 my-sm-0"><a class="button" href="#">Invite</a></button>
</div>
<section id="company" class="d-flex flex-wrap justify-content-around align-content-around mt-5">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                </tr>
                            </thead>
                    @foreach ($user as $users)
                            <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> {{$users->id}} </th>
                                    <td>{{$users->name}}</td>
                                </tr>
                            </tbody>
                    @endforeach
                    </table>
                    </div>     
                </div>  
                
    </div>
@endsection

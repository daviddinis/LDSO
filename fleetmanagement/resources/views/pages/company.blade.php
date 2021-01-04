@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashBoardPage.js') }}" rel="stylesheet" defer></script>
@endsection

@section('content')
<div class="container" style="padding-top: 3%">
    <button class="btn btn-secondary my-2 my-sm-0"><a class="button" href="/company/user/create">Invite</a></button>
</div>
<section id="company" class="d-flex flex-wrap justify-content-around align-content-around mt-5">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                    @foreach ($users as $user)
                            <tbody>
                                <tr class="table-primary">
                                    <th scope="row"> {{$user->id}} </th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <form style="margin-left: 10px; float:right;" method="post" action="{{route('company.destroy', $user->id)}}" >
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle " type=" submit">
                                                <i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                    @endforeach
                    </table>
                    </div>     
                </div>  
                
    </div>
@endsection

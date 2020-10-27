<div class="card mb-3 w-100" style="max-width: 20rem;">

    <div class="card-header">
        {{ $driver->name }}
        <form style="margin-left: 10px; float:right;" method="post" action="{{route('driver.destroy', $driver->id)}}" >
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button onclick="return confirm('Are you sure?')" class="btn btn-secondary btn-sm rounded-circle " type=" submit">
                <i class="fa fa-trash"></i></button>
        </form>
        <a href="/driver/{{$driver->id}}/edit" class="btn btn-info btn-sm rounded-circle" style="float:right">
            <i class="fa fa-pencil"></i>
        </a>
    </div>
    <div class="card-body">
        <b>Email: </b> {{ $driver->email }} <br>
        <b>IdCard: </b> {{ $driver->id_card }} <br>
        <b>DriverLicense: </b> {{ $driver->drivers_license }} <br>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="navTitle">
  <a class="navbar-brand" id="fleetTitle" href="#">iFleet</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    @if (Auth::check())
    <ul class="navbar-nav mr-auto" id="navbarOptions">
      <li class="nav-item">
        <a class="nav-link" href="{{route('car.index')}}">Cars</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('driver.index')}}">Drivers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Company</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('history.index')}}">History</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <span style="font-size: 150%; padding-right: 15px">{{Auth::user()->name}}</span>
      <button class="btn btn-secondary my-2 my-sm-0"><a class="button" href="{{url('/logout')}}">Logout</a></button>
    </form>
    @endif
  </div>
</nav>
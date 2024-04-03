<nav class="navbar navbar-top navbar-expand-md" id="navbar-main">
  <div class="container-fluid">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2 mt-3">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active"> {{ Route::currentRouteName() }} </li>
      </ol>
    </nav>
    <ul class="navbar-nav align-items-center d-none d-md-flex">
      <li class="nav-item dropdown">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">
            <span class="ni ni-circle-08" style="font-size: 20px;"></span>
            <div class="media-body ml-2 d-none d-lg-block">
              <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
            </div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
            <i class="ni ni-user-run"></i>
            <span>{{ __('Logout') }}</span>
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>
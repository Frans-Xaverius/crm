<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="..."
                style="width: 80px; max-height: fit-content;">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="ni ni-circle-08" style="font-size: 100px; margin-top: 20px;"></span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <h3> General </h3>
            <ul class="navbar-nav p-1">
                <li class="nav-item">
                    <a class="nav-link text-blue" href="{{ route('home') }}">
                       <i class="bi bi-house-door"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-blue" href="#navbar-media" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="navbar-media">
                        <i class="ni ni-app" style="margin-right: -5px;"></i>
                        <span class="nav-link-text">{{ __('Media') }}</span>
                    </a>
                    <div class="collapse" id="navbar-media">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-blue" href="{{ route('media.whatsapp') }}">
                                   {{ __('Whats App') }}
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-blue" href="{{ route('media.pabx') }}">
                                   {{ __('PABX') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-blue" href="#navbar-laporan" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="navbar-laporan">
                        <i class="ni ni-app" style="margin-right: -5px;"></i>
                        <span class="nav-link-text">{{ __('Laporan') }}</span>
                    </a>
                    <div class="collapse" id="navbar-laporan">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-blue" href="{{ route('laporan.log-panggilan') }}">
                                   {{ __('Log Panggilan') }}
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-blue" href="{{ route('laporan.whatsapp') }}">
                                   {{ __('Whats App') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            @if (auth()->user()->detailRole->name == "Super Admin")
                <div class="menu-access mt-4" attr-role="SU">
                    <h3> Super Admin </h3>
                    <ul class="navbar-nav p-1">
                        <li class="nav-item">
                            <a class="nav-link text-blue" href="#navbar-manage" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="navbar-manage">
                                <i class="ni ni-app" style="margin-right: -5px;"></i>
                                <span class="nav-link-text">{{ __('Manage') }}</span>
                            </a>
                            <div class="collapse" id="navbar-manage">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" href="{{ route('manage.user') }}">
                                           {{ __('User') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" href="{{ route('manage.tag') }}">
                                           {{ __('Tag') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" href="{{ route('pertanyaan') }}">
                               <i class="bi bi-question-square"></i> {{ __('Pertanyaan') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>
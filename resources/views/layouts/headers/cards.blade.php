<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        @php
                            $data = [
                                (object) [
                                    'id' => 'fb',
                                    'name' => 'Facebook',
                                    'user' => 0,
                                    'percent' => 0,
                                    'route' => route('application.facebook'),
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                ],
                                (object) [
                                    'id' => 'ig',
                                    'name' => 'Instagram',
                                    'user' => 0,
                                    'percent' => 0,
                                    // 'persen_type' => 'down',
                                    'route' => route('application.instagram'),
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                ],
                                (object) [
                                    'id' => 'wa',
                                    'name' => 'WA Business',
                                    'user' => 0,
                                    'percent' => 0,
                                    'route' => route('application.whatsapp'),
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                ],
                                (object) [
                                    'id' => 'cc',
                                    'name' => 'Call Center',
                                    'user' => 0,
                                    'percent' => 0,
                                    'route' => route('application.callcenter'),
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                ],
                                (object) [
                                    'id' => 'wc',
                                    'name' => 'Web Chat',
                                    'user' => 0,
                                    'percent' => 0,
                                    'route' => route('application.webchat'),
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                ],
                            ];
                        @endphp
                        @foreach ($data as $v)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <a href="{{ $v->route }}">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light-{{ $v->color }}">
                                                    <i class="{{ $v->icon }} px-1 text-{{ $v->color }}"></i>
                                                </div>
                                                <h5 class="card-title text-muted mb-0 ml-1">
                                                    {{ $v->name }}
                                                </h5>
                                            </div>
                                            <span class="h1 font-weight-bold mb-0"
                                                id="{{ !empty($v->id) ? $v->id : '' }}">{{ number_format($v->user) }}</span>
                                            <span class="h4 font-weight-bold mb-0">User</span>
                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                @if (!empty($v->percent_type) && $v->percent_type == 'down')
                                                    <span class="text-danger mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span
                                                            id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @else
                                                    <span class="text-success mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span
                                                            id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @endif
                                                <span class="text-nowrap">Since yerterday</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="text-default mb-0 text-center">Total User</h2>
                            <hr class="my-3">
                            <ul class="nav nav-pills justify-content-center">
                                <li class="nav-item pr-0">
                                    <a href="#" class="nav-link py-1 px-2 btn-filter-dmy active" data-toggle="tab"
                                        data-target="#dmy-d">
                                        <span class="d-none d-md-block">Daily</span>
                                        <span class="d-md-none">D</span>
                                    </a>
                                </li>
                                <li class="nav-item pr-0">
                                    <a href="#" class="nav-link py-1 px-2 btn-filter-dmy" data-toggle="tab"
                                        data-target="#dmy-w">
                                        <span class="d-none d-md-block">Weekly</span>
                                        <span class="d-md-none">W</span>
                                    </a>
                                </li>
                                <li class="nav-item pr-0">
                                    <a href="#" class="nav-link py-1 px-2 btn-filter-dmy" data-toggle="tab"
                                        data-target="#dmy-m">
                                        <span class="d-none d-md-block">Monthly</span>
                                        <span class="d-md-none">M</span>
                                    </a>
                                </li>
                                <li class="nav-item pr-0">
                                    <a href="#" class="nav-link py-1 px-2 btn-filter-dmy" data-toggle="tab"
                                        data-target="#dmy-y">
                                        <span class="d-none d-md-block">Yearly</span>
                                        <span class="d-md-none">Y</span>
                                    </a>
                                </li>
                            </ul>
                            @php
                                $dmy = ['d', 'w', 'm', 'y'];
                            @endphp
                            @foreach ($dmy as $k => $v)
                                <div class="dmy" id="dmy-{{ $v }}" {!! $k != 0 ? 'style="display: none"' : '' !!}>
                                    <div class="text-center mt-4">
                                        <span class="h1 font-weight-bold mb-0" style="font-size: 40px;"
                                            id="dmy-{{ $v }}-data">0</span>
                                    </div>
                                    <p class="mt-3 mb-0 text-muted text-sm text-center">
                                        <span class="text-success mr-2 font-weight-bold" style="font-size: large">
                                            <i class="fas fa-arrow-up"></i> <span
                                                id="dmy-{{ $v }}-percent">0%</span>
                                        </span>
                                        <span class="text-nowrap">Since yesterday</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="my-3">
        </div>
    </div>
</div>

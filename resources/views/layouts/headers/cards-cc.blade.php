<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <div class="d-flex justify-content-between">
                <b style="font-size: x-large;">Call Center</b>
                <input type="date" class="form-control" style="width: 300px;" id="date-filter"
                    value="<?= date('Y-m-d') ?>" />
            </div>
            <!-- Card stats -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-9">
                    <div class="row mb-3">
                        @php
                            $data = [
                                (object) [
                                    'id' => 'answered',
                                    'name' => 'Answered',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'type' => 'tab',
                                ],
                                (object) [
                                    'id' => 'unanswered',
                                    'name' => 'Unanswered',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'type' => 'tab',
                                ],
                                (object) [
                                    'id' => 'solved',
                                    'name' => 'Solved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'type' => 'tab',
                                ],
                            ];
                        @endphp
                        @foreach ($data as $v)
                            <div class="col-md-4 mb-sm-3 mb-md-0">
                                <div class="card shadow">
                                    <a href="#" {!! !empty($v->type) && $v->type == 'modal' ? 'data-toggle="modal" data-target="#modalMessageDetail"' : '' !!}{!! !empty($v->type) && $v->type == 'tab' ? 'class="btn-table-tab" data-target="#' . $v->id . '-tab"' : '' !!}>
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
                                                id="{{ !empty($v->id) ? $v->id : '' }}">{{ $v->number }}</span>
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
                                                <span class="text-nowrap">Since yesterday</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card bg-gradient-white shadow card-tab">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="text-default mb-0">Calls</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item pr-0">
                                            <a href="#" class="nav-link py-1 px-2 btn-filter-chart active"
                                                data-target="#chartdiv" data-toggle="tab">
                                                <span class="d-none d-md-block">Daily</span>
                                                <span class="d-md-none">D</span>
                                            </a>
                                        </li>
                                        <li class="nav-item pr-0">
                                            <a href="#" class="nav-link py-1 px-2 btn-filter-chart"
                                                data-target="#chartdiv2" data-toggle="tab">
                                                <span class="d-none d-md-block">Monthly</span>
                                                <span class="d-md-none">M</span>
                                            </a>
                                        </li>
                                        <li class="nav-item pr-0">
                                            <a href="#" class="nav-link py-1 px-2 btn-filter-chart"
                                                data-target="#chartdiv3" data-toggle="tab">
                                                <span class="d-none d-md-block">Yearly</span>
                                                <span class="d-md-none">Y</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                @include('layouts.chart.dashboard-line-cc')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="col">
                                <h5 class="text-uppercase text-muted text-center">Total All Call</h5>
                            </div>
                            <!-- Divider -->
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
                                $dmy = ['d', 'm', 'y'];
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

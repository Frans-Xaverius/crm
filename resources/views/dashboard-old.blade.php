@extends('layouts.app')

@section('content')

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-white shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">Total User</h2>
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
                        <div class="chart mt-2">
                            @include('layouts.chart.dashboard-line')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0 text-center">Total User</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        {{-- <div class="chart">
                            <canvas id="chart-orders" class="chart-canvas" style="width: 200px;"></canvas>
                            <?php /*<canvas id="myChart" style="width: 200px;"></canvas>*/?>
                        </div> --}}
                        {{-- <div id="chartdivv2-p"> --}}
                        <div id="chartdivv2" style="height: 200px; width: 100%"></div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

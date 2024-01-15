@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-wc')

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-xl-8 mb-2 mb-xl-0">
                <div class="card bg-gradient-white shadow card-tab">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">Total Visit</h2>
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
                            @include('layouts.chart.dashboard-line-wc')
                        </div>
                    </div>
                </div>
                @php
                    $data = ['read', 'unread', 'solved', 'unsolved'];
                @endphp
                @foreach ($data as $v)
                    <div class="card bg-gradient-white shadow card-tab" id="{{ $v }}-tab" style="display: none">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="text-default mb-0">{{ ucfirst($v) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="{{ $v }}-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="col">
                            <h2 class="text-default text-center mb-0">Total All Chat</h2>
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
                                        <i class="fas fa-arrow-up"></i> <span id="dmy-{{ $v }}-percent">0%</span>
                                    </span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
        $('.btn-table-tab').click(function(e) {
            e.preventDefault();
            $('.card-tab').hide();
            $($(this).data('target')).show();
        });

        $('.btn-filter-chart').click(function(e) {
            e.preventDefault();
            $('.crartdiv').hide();
            $($(this).data('target')).show();
        });

        $('.btn-filter-dmy').click(function(e) {
            e.preventDefault();
            $('.dmy').hide();
            $($(this).data('target')).show();
        });

        var isChart = false;

        function loadData(date = null) {
            $.ajax({
                type: "get",
                url: "{{ route('api.web') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    $('#read').text(r.card.read);
                    $('#pread').text(r.persentage.read + ' %');
                    $('#unread').text(r.card.unread);
                    $('#punread').text(r.persentage.unread + ' %');
                    $('#solved').text(r.card.solved);
                    $('#psolved').text(r.persentage.solved + ' %');
                    $('#unsolved').text(r.card.unsolved);
                    $('#punsolved').text(r.persentage.unsolved + ' %');

                    $('.datatable').DataTable().clear().destroy();

                    var data = ['read', 'unread', 'solved', 'unsolved'];
                    $.each(data, function(ii, vv) {
                        var html = ``;
                        $.each(r.data[vv], function(i, v) {
                            html += `
                                <tr>
                                    <td class="text-center">${i + 1}</td>
                                    <td>${v.name}</td>
                                    <td>${inaDate(v.updated_at)}</td>
                                    <td>${v.resolved_at != null ? '<div class="text-success btn-sm">Solved</div>' : '<div class="text-danger btn-sm">Unsolved</div>'}</td>
                                     
                                </tr>
                            `;
                        });
                        $(`#${vv}-tbody`).html(html);
                    });

                    $('.datatable').DataTable({
                        language: {
                            paginate: {
                                next: '&#8594;', // or '→'
                                previous: '&#8592;' // or '←' 
                            }
                        }
                    });

                    // graph
                    if (isChart == false) {
                        chart('chartdiv', r.graph.daily);
                        chart('chartdiv2', r.graph.monthly);
                        chart('chartdiv3', r.graph.yearly);
                        isChart = true;
                    }

                    // dmy
                    var d = r.graph.daily[r.graph.daily.length - 1];
                    var m = r.graph.monthly[r.graph.monthly.length - 1];
                    var y = r.graph.yearly.filter(v => v.date == new Date().getFullYear())[0];

                    var pd = r.graph.daily[r.graph.daily.length - 2];
                    var pm = r.graph.monthly[r.graph.monthly.length - 2];
                    var py = r.graph.yearly.filter(v => v.date == new Date().getFullYear() - 1);

                    $('#dmy-d-data').text(d.read + d.unread);
                    $('#dmy-m-data').text(m.read + m.unread);
                    $('#dmy-y-data').text(y.read + y.unread);

                    $('#dmy-d-percent').text(get_percentage(d.read + d.unread, (d.read + d.unread) - (pd.read +
                        pd.unread)) + "%");
                    $('#dmy-m-percent').text(get_percentage(m.read + m.unread, (m.read + m.unread) - (pm.read +
                        pm.unread)) + "%");

                    if (py.length) {
                        py = py[0];
                        $('#dmy-y-percent').text(get_percentage(y.read + y.unread, (y.read + y.unread) - (py
                            .read + py.unread)) + "%");
                    }
                }
            });
        }

        loadData($('#date-filter').val());

        $('#date-filter').change(function(e) {
            e.preventDefault();
            loadData($(this).val());
        });
    </script>
@endpush

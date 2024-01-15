@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-email')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-9 mb-2">
                <div class="card bg-gradient-white shadow card-tab" id="home-tab">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">Account Insight</h2>
                            </div>
                            <div class="col" style="margin-left: -280px;">
                                <div class="justify-content-start" style="float: left; margin-top: 5px;">

                                </div>
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
                        <div class="chart">
                            @include('layouts.chart.dashboard-line-email')
                        </div>
                    </div>
                </div>
                <div class="card bg-gradient-white shadow card-tab" id="sent-email-tab" style="display: none">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">Sent Mail</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="htmltable1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [
                                            (object) [
                                                'nama' => 'Reihan Sulid',
                                                'pengirim' => 'reihansulid@gmail.com',
                                                'penerima' => 'jakilupa@gmail.com',
                                                'tanngal' => '03-10-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Nilam Hastuti',
                                                'pengirim' => 'reihansulid@gmail.com',
                                                'penerima' => 'nilam_hastuti123@gmail.com',
                                                'tanngal' => '12-09-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Puspa Agustina',
                                                'pengirim' => 'puspa_agustina007@gmail.com',
                                                'penerima' => 'reihansulid@gmail.com',
                                                'tanngal' => '20-09-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Irsad Hidayat',
                                                'pengirim' => 'irsad.hidayat442@gmail.com',
                                                'penerima' => 'sihombing.marsito@yahoo.com',
                                                'tanngal' => '03-10-2022',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($data as $k => $v)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>{{ $v->nama }}</td>
                                            <td>{{ $v->pengirim }}</td>
                                            <td>{{ $v->penerima }}</td>
                                            <td>{{ $v->tanngal }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card bg-gradient-white shadow card-tab" id="inbox-tab" style="display: none">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">Inbox</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="htmltable2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [
                                            (object) [
                                                'nama' => 'Irsad Hidayat',
                                                'pengirim' => 'irsad.hidayat442@gmail.com',
                                                'penerima' => 'sihombing.marsito@yahoo.com',
                                                'tanngal' => '03-10-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Nilam Hastuti',
                                                'pengirim' => 'reihansulid@gmail.com',
                                                'penerima' => 'nilam_hastuti123@gmail.com',
                                                'tanngal' => '12-09-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Reihan Sulid',
                                                'pengirim' => 'reihansulid@gmail.com',
                                                'penerima' => 'jakilupa@gmail.com',
                                                'tanngal' => '03-10-2022',
                                            ],
                                            (object) [
                                                'nama' => 'Puspa Agustina',
                                                'pengirim' => 'puspa_agustina007@gmail.com',
                                                'penerima' => 'reihansulid@gmail.com',
                                                'tanngal' => '20-09-2022',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($data as $k => $v)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>{{ $v->nama }}</td>
                                            <td>{{ $v->pengirim }}</td>
                                            <td>{{ $v->penerima }}</td>
                                            <td>{{ $v->tanngal }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @php
                    $data = ['read', 'unread', 'solved', 'unsolved', 'spam'];
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
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#htmltable1').DataTable({
                "paging": false,
            });
            $('#htmltable2').DataTable({
                "paging": false,
            });
        });

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

        // function loadData() {
        //     $.ajax({
        //         type: "get",
        //         url: "{{ route('api.email') }}",
        //         // data: "data",
        //         dataType: "json",
        //         success: function(r) {
        //             var total = r.is_unresponded + r.solved + r.unsolved

        //             $('#sent-email').text(0);
        //             $('#inbox').text(r.inbox);
        //             $('#spam').text(0);

        //             $('#read').text(0);
        //             $('#unread').text(0);
        //             $('#solved').text(r.solved);
        //             $('#unsolved').text(r.unsolved);

        //             $('#total').text(total);

        //             const monthNames = ["January", "February", "March", "April", "May", "June",
        //                 "July", "August", "September", "October", "November", "December"
        //             ];

        //             const d = new Date();

        //             // var data = [{
        //             //     "date": monthNames[d.getMonth()] + " 2022",
        //             //     "sentMessages": r.is_unresponded,
        //             //     "inbox": r.inbox
        //             // }];

        // var data = [{
        //     "date": "Oct 2021",
        //     "sentMessages": 1196,
        //     "inbox": 1148
        // }, {
        //     "date": "Nov 2021",
        //     "sentMessages": 1163,
        //     "inbox": 1138
        // }, {
        //     "date": "Dec 2021",
        //     "sentMessages": 1266,
        //     "inbox": 1138
        // }];

        // chart(data);
        //         }
        //     });
        // }

        // loadData();

        var isChart = false;

        function loadData(date = null) {
            $.ajax({
                type: "get",
                url: "{{ route('api.email') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    $('#sent-email').text(r.card.solved);
                    $('#psent-email').text(r.persentage.solved + ' %');
                    $('#inbox').text(r.card.message);
                    $('#pinbox').text(r.persentage.message + ' %');
                    $('#spam').text(0);

                    $('#read').text(r.card.read);
                    $('#pread').text(r.persentage.read + ' %');
                    $('#unread').text(r.card.unread);
                    $('#punread').text(r.persentage.unread + ' %');
                    $('#solved').text(r.card.solved);
                    $('#psolved').text(r.persentage.solved + ' %');
                    $('#unsolved').text(r.card.unsolved);
                    $('#punsolved').text(r.persentage.unsolved + ' %');

                    $('#total').text(r.card.read + r.card.unread);

                    $('.datatable').DataTable().clear().destroy();

                    var data = ['read', 'unread', 'solved', 'unsolved', 'spam'];
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
                    })

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

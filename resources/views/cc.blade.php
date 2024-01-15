@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-cc')

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-white shadow card-tab">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0">History</h2>
                            </div>
                            <div class="col-md-4 text-right"> <button id="exporttable" class="btn btn-primary">Export</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="htmltable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Tanggal</th>
                                        <th>Nomor</th>
                                        <th>Respon</th>
                                        <th>Durasi</th>
                                        <th>Hasil</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody id="history-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @php
                    $data = ['answered', 'unanswered', 'solved'];
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
                                            <th>Nomor</th>
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
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Result</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="background-color: rgb(99, 223, 181)">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="card-title text-uppercase text-white mb-0">
                                            Terpanggil
                                            <span class="ml-3">
                                                <i class="fa fa-arrow-up"></i>
                                                <span id="p-t">0%</span>
                                            </span>
                                            </h5>
                                            <span class="h1 font-weight-bold" id="d-t">0</span>
                                    </div>
                                </div>
                                {{-- <p class="mt-1 mb-0 text-default text-sm">
                                    <span class="text-nowrap">Missed Call</span>
                                </p> --}}
                            </div>
                        </div>
                        <div class="card" style="background-color: #f1bb88; margin-top:20px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="card-title text-uppercase text-white mb-0">
                                            Menunggu
                                            <span class="ml-3">
                                                <i class="fa fa-arrow-up"></i>
                                                <span id="p-m">0%</span>
                                            </span>
                                            </h5>
                                            <span class="h1 font-weight-bold" id="d-m">0</span>
                                    </div>
                                </div>
                                {{-- <p class="mt-1 mb-0 text-default text-sm">
                                    <span class="text-nowrap">Missed Call</span>
                                </p> --}}
                            </div>
                        </div>
                        <div class="card" style="background-color: #e98a7e; margin-top:20px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="card-title text-uppercase text-white mb-0">
                                            Sibuk
                                            <span class="ml-3">
                                                <i class="fa fa-arrow-up"></i>
                                                <span id="p-s">0%</span>
                                            </span>
                                            </h5>
                                            <span class="h1 font-weight-bold" id="d-s">0</span>
                                    </div>
                                </div>
                                {{-- <p class="mt-1 mb-0 text-default text-sm">
                                    <span class="text-nowrap">Missed Call</span>
                                </p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
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
                url: "{{ route('api.cc') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    $('#answered').text(r.card.answered);
                    $('#panswered').text(r.persentage.answered + ' %');
                    $('#unanswered').text(r.card.unanswered);
                    $('#punanswered').text(r.persentage.unanswered + ' %');
                    $('#solved').text(r.card.solved);
                    $('#psolved').text(r.persentage.solved + ' %');

                    $('#d-t').text(r.card.terpanggil);
                    $('#p-t').text(r.persentage.terpanggil + ' %');
                    $('#d-m').text(r.card.menunggu);
                    $('#p-m').text(r.persentage.menunggu + ' %');
                    $('#d-s').text(r.card.sibuk);
                    $('#p-s').text(r.persentage.sibuk + ' %');

                    $('.datatable').DataTable().clear().destroy();
                    $('#htmltable').DataTable().clear().destroy();

                    var data = ['answered', 'unanswered', 'solved'];
                    $.each(data, function(ii, vv) {
                        var html = ``;
                        $.each(r.data[vv], function(i, v) {
                            html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td>${v.clid}</td>
                                <td>${inaDate(v.calldate)}</td>
                                <td>${v.solved != null ? '<div class="text-success btn-sm">Solved</div>' : '<div class="text-danger btn-sm">Unsolved</div>'}</td>
                                 
                            </tr>
                        `;
                        });
                        $(`#${vv}-tbody`).html(html);
                    });

                    var html = ``;
                    $.each(r.history, function(i, v) {
                        html += `
                            <tr>
                                <td class="align-middle text-center">${parseInt(i) + 1}</td>
                                <td class="align-middle">${inaDate(v.calldate)}</td>
                                <td class="align-middle">${v.src}</td>
                                <td class="align-middle">${v.lastapp}</td>
                                <td class="align-middle">${v.duration}</td>
                                <td class="align-middle">${v.disposition}</td>
                                <td class="align-middle">
                                    <input class="cc-name-input cc-name-input-${v.uniqueid.replace('.', '')} form-control p-1" style="height: 1%;width: auto;display: none;" data-id="${v.uniqueid}" type="text" value="${v.cc_detail ? v.cc_detail.src : ''}">
                                    <div class="d-flex align-items-center">
                                        <div class="cc-name-input-${v.uniqueid.replace('.', '')}-text mr-1">${v.cc_detail ? v.cc_detail.src : ``}</div>
                                        <button class="btn btn-primary btn-sm btn-cc-name-input" data-target=".cc-name-input-${v.uniqueid.replace('.', '')}">Edit</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    $(`#history-tbody`).html(html);

                    $('#htmltable').DataTable({
                        language: {
                            paginate: {
                                next: '&#8594;', // or '→'
                                previous: '&#8592;' // or '←' 
                            }
                        },
                        aLengthMenu: [
                            [-1, 10, 25, 50, 100],
                            ["All", 10, 25, 50, 100]
                        ],
                        iDisplayLength: -1
                    });
                    $('.datatable').DataTable({
                        language: {
                            paginate: {
                                next: '&#8594;', // or '→'
                                previous: '&#8592;' // or '←' 
                            }
                        },
                        aLengthMenu: [
                            [-1, 10, 25, 50, 100],
                            ["All", 10, 25, 50, 100]
                        ],
                        iDisplayLength: -1
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

                    $('#dmy-d-data').text(d.answer + d.unanswer);
                    $('#dmy-m-data').text(m.answer + m.unanswer);
                    $('#dmy-y-data').text(y.answer + y.unanswer);

                    $('#dmy-d-percent').text(get_percentage(d.answer + d.unanswer, (d.answer + d.unanswer) - (pd
                        .answer + pd.unanswer)) + "%");
                    $('#dmy-m-percent').text(get_percentage(m.answer + m.unanswer, (m.answer + m.unanswer) - (pm
                        .answer + pm.unanswer)) + "%");

                    if (py.length) {
                        py = py[0];
                        $('#dmy-y-percent').text(get_percentage(y.answer + y.unanswer, (y.answer + y.unanswer) -
                            (py.answer + py.unanswer)) + "%");
                    }
                }
            });
        }

        loadData($('#date-filter').val());

        $('#date-filter').change(function(e) {
            e.preventDefault();
            loadData($(this).val());
        });

        $('body').on('change', '.cc-name-input', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var tid = id + '';
            var name = $(this).val();

            $.ajax({
                type: "post",
                url: "{{ route('api.cc.update') }}",
                data: {
                    id,
                    name
                },
                dataType: "json",
                success: function(r) {
                    $('.btn-cc-name-input').show();
                    $('.cc-name-input').hide();
                    $(`.cc-name-input-${tid.replace('.', '')}-text`).text(name).show();
                }
            });
        });

        $('body').on('click', '.btn-cc-name-input', function(e) {
            e.preventDefault();
            $(this).hide();
            $($(this).data('target')).show();
            $($(this).data('target') + '-text').hide();
        });
    </script>
@endpush

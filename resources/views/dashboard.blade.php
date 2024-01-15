@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

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

@push('js2')
    {{-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script> --}}
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    {{-- <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script> --}}
    <script>
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

        function loadData(date = null) {
            $.ajax({
                type: "get",
                url: "{{ route('api.dashboard') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    $('#fb').text(r.card.facebook);
                    $('#pfb').text(r.persentage.facebook + ' %');
                    $('#ig').text(r.card.instagram);
                    $('#pig').text(r.persentage.instagram + ' %');
                    $('#wa').text(r.card.whatsapp);
                    $('#pwa').text(r.persentage.whatsapp + ' %');
                    $('#cc').text(r.card.callcenter);
                    $('#pcc').text(r.persentage.callcenter + ' %');
                    $('#wc').text(r.card.web_chat);
                    $('#pwc').text(r.persentage.web_chat + ' %');

                    $('#total').text(r.card.message);

                    // // graph
                    chart('chartdiv', r.graph.daily);
                    chart('chartdiv2', r.graph.monthly);
                    chart('chartdiv3', r.graph.yearly);

                    // // dmy
                    var d = r.graph.daily[r.graph.daily.length - 1];
                    var w = r.graph.weekly[r.graph.weekly.length - 1];
                    var m = r.graph.monthly[r.graph.monthly.length - 1];
                    var y = r.graph.yearly.filter(v => v.date == new Date().getFullYear())[0];

                    var pd = r.graph.daily[r.graph.daily.length - 2];
                    var pw = r.graph.weekly[r.graph.weekly.length - 2];
                    var pm = r.graph.monthly[r.graph.monthly.length - 2];
                    var py = r.graph.yearly.filter(v => v.date == new Date().getFullYear() - 1);

                    $('#dmy-d-data').text(d.facebook + d.instagram + d.whatsapp + d.web_chat + d.callcenter);
                    $('#dmy-w-data').text(w.facebook + w.instagram + w.whatsapp + w.web_chat + w.callcenter);
                    $('#dmy-m-data').text(m.facebook + m.instagram + m.whatsapp + m.web_chat + m.callcenter);
                    $('#dmy-y-data').text(y.facebook + y.instagram + y.whatsapp + y.web_chat + y.callcenter);

                    $('#dmy-d-percent').text(get_percentage(d.facebook + d.instagram + d.whatsapp + d.web_chat +
                        d.callcenter,
                        (d.facebook + d.instagram + d.whatsapp + d.web_chat + d.callcenter) - (pd
                            .facebook + pd
                            .instagram + pd.whatsapp + pd.web_chat + pd.callcenter)) + "%");
                    $('#dmy-w-percent').text(get_percentage(w.facebook + w.instagram + w.whatsapp + w.web_chat +
                        w.callcenter,
                        (w.facebook + w.instagram + w.whatsapp + w.web_chat + w.callcenter) - (pw.facebook + pw.instagram + pw.whatsapp + pw.web_chat + pw.callcenter)) + "%");
                    $('#dmy-m-percent').text(get_percentage(m.facebook + m.instagram + m.whatsapp + m.web_chat +
                        m.callcenter,
                        (m.facebook + m.instagram + m.whatsapp + m.web_chat + m.callcenter) - (pm
                            .facebook + pm
                            .instagram + pm.whatsapp + pm.web_chat + pm.callcenter)) + "%");

                    if (py.length) {
                        py = py[0];
                        $('#dmy-y-percent').text(get_percentage(y.facebook + y.instagram + y.whatsapp + y
                                .web_chat + m.callcenter, (y.facebook + y.instagram + y.whatsapp + y
                                    .web_chat + m.callcenter) - (py
                                    .facebook + py.instagram + py.whatsapp + py.web_chat + pm.callcenter)) +
                            "%");
                    }

                    var data = [{
                            category: "Facebook",
                            value: d.facebook
                        },
                        {
                            category: "Instagram",
                            value: d.instagram
                        },
                        {
                            category: "WA Business",
                            value: d.whatsapp
                        },
                        {
                            category: "Call Center",
                            value: d.callcenter
                        },
                        {
                            category: "Web Chat",
                            value: d.web_chat
                        },
                    ];

                    chart_('chartdivv2', data);
                }
            });
        }

        loadData("{{ date('Y-m-d') }}");

        function chart_(selector, data) {
            // $(`#${selector}-p`).empty().html(`<div id="${selector}" style="height: 200px; width: 100%"></div>`);
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new(selector);


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    layout: root.verticalLayout
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    valueField: "value",
                    categoryField: "category"
                }));


                // Set data
                // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                series.data.setAll(data);


                // Play initial series animation
                // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                series.appear(1000, 100);

            }); // end am5.ready()

        }
    </script>
@endpush

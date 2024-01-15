@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-report')

    <div class="container-fluid mt--7">
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
    <script>
        function loadData(date = null) {
            $.ajax({
                type: "get",
                url: "{{ route('api.report') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // conversation
                    $('#read-message').text(r.conversation.card.read);
                    $('#pread-message').text(r.conversation.persentage.read + ' %');
                    $('#unread-message').text(r.conversation.card.unread);
                    $('#punread-message').text(r.conversation.persentage.unread + ' %');
                    $('#solved').text(r.conversation.card.solved);
                    $('#psolved').text(r.conversation.persentage.solved + ' %');
                    $('#unsolved').text(r.conversation.card.unsolved);
                    $('#punsolved').text(r.conversation.persentage.unsolved + ' %');

                    $('#total-conversations').text(r.conversation.card.totalConversation);
                    $('#ptotal-conversations').text(r.conversation.persentage.totalConversation + ' %');
                    $('#total-sent-message').text(r.conversation.card.totalSent);
                    $('#ptotal-sent-message').text(r.conversation.persentage.totalSent + ' %');
                    $('#total-incoming-call').text(r.conversation.card.totalIncomingCall);
                    $('#ptotal-incoming-call').text(r.conversation.persentage.totalIncomingCall + ' %');

                    $('#solved-conversations').text(r.conversation.card.solved);
                    $('#psolved-conversations').text(r.conversation.persentage.solved + ' %');
                    $('#unsolved-conversations').text(r.conversation.card.unsolved);
                    $('#punsolved-conversations').text(r.conversation.persentage.unsolved + ' %');
                    $('#total-user').text(r.conversation.card.totalUser);
                    $('#ptotal-user').text(r.conversation.persentage.totalUser + ' %');

                    // tagging
                    $.each(r.tagging.card, function(i, v) {
                        $(`#tags${i}`).text(v);
                    });
                    $.each(r.tagging.persentage, function(i, v) {
                        $(`#ptags${i}`).text(v);
                    });

                    // call
                    $('#incoming').text(r.call.card.incoming);
                    $('#pincoming').text(r.call.persentage.incoming + ' %');
                    $('#missed').text(r.call.card.missed);
                    $('#pmissed').text(r.call.persentage.missed + ' %');
                    $('#hold').text(r.call.card.hold);
                    $('#phold').text(r.call.persentage.hold + ' %');

                    // chart
                    var data = [{
                            category: "Incoming Call",
                            value: r.call.card.incoming
                        },
                        {
                            category: "Missed Call",
                            value: r.call.card.missed
                        },
                        {
                            category: "Hold",
                            value: r.call.card.hold
                        }
                    ];
                    chart_('chartdiv', data);

                    // // table
                    $('.datatable').DataTable().clear().destroy();
                    var html = ``;
                    $.each(r.conversation.data.history, function(i, v) {
                        html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td>${v.Name}</td>
                                <td>${v.Channel}</td>
                                <td>${v.Solved == true ? '<div class="text-success btn-sm">Solved</div>' : '<div class="text-danger btn-sm">Unsolved</div>'}</td>
                                <td>${inaDate(v['Created At'])}</td>
                            </tr>
                    `;
                    });
                    $(`#cm-tbody`).html(html);

                    // tags
                    var html = ``;
                    $.each(r.conversation.data.history, function(i, v) {
                        html += `
                            <tr>
                                <td class="text-center" width="1%">${i + 1}</td>
                                <td>${v.Name}</td>
                                <td>${v.Tag}</td>
                            </tr>
                    `;
                    });
                    $(`#tag-tbody`).html(html);

                    // rating
                    var html = ``;
                    $.each(r.conversation.data.history, function(i, v) {
                        html += `
                            <tr>
                                <td class="text-center" width="1%">${i + 1}</td>
                                <td>${v.Name}</td>
                                <td>${v.Rating}</td>
                            </tr>
                    `;
                    });
                    $(`#rating-tbody`).html(html)

                    var html = ``;
                    $.each(r.call.data.history, function(i, v) {
                        if (v) {
                            html += `
                            <tr>
                                <td class="text-center">${parseInt(i) + 1}</td>
                                <td>${inaDate(v.calldate)}</td>
                                <td>${v.src}</td>
                                <td>${v.lastapp}</td>
                                <td>${v.duration}</td>
                                <td>${v.disposition}</td>
                            </tr>
                        `;
                        }
                    });
                    $(`#history-tbody`).html(html);

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
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.fb') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // card
                    $('#fbl').text(r.card.likes);
                    $('#pfbl').text(r.persentage.likes + ' %');
                    $('#fbc').text(r.card.comments);
                    $('#pfbc').text(r.persentage.comments + ' %');
                    $('#fbm').text(r.card.message);
                    $('#pfbm').text(r.persentage.message + ' %');
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.ig') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // card
                    $('#igf').text(r.card.followers);
                    $('#pigf').text(r.persentage.followers + ' %');
                    $('#igl').text(r.card.likes);
                    $('#pigl').text(r.persentage.likes + ' %');
                    $('#igc').text(r.card.comments);
                    $('#pigc').text(r.persentage.comments + ' %');
                    $('#igm').text(r.card.message);
                    $('#pigm').text(r.persentage.message + ' %');
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.wa') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // card
                    $('#war').text(r.card.read);
                    $('#pwar').text(r.persentage.read + ' %');
                    $('#wau').text(r.card.unread);
                    $('#pwau').text(r.persentage.unread + ' %');
                    $('#was').text(r.card.solved);
                    $('#pwas').text(r.persentage.solved + ' %');
                    $('#waun').text(r.card.unsolved);
                    $('#pwaun').text(r.persentage.unsolved + ' %');
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.cc') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // card
                    $('#cca').text(r.card.answered);
                    $('#pcca').text(r.persentage.answered + ' %');
                    $('#ccu').text(r.card.unanswered);
                    $('#pccu').text(r.persentage.unanswered + ' %');
                    $('#ccs').text(r.card.solved);
                    $('#pccs').text(r.persentage.solved + ' %');
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.web') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    // card
                    $('#wcr').text(r.card.read);
                    $('#pwcr').text(r.persentage.read + ' %');
                    $('#wcu').text(r.card.unread);
                    $('#pwcu').text(r.persentage.unread + ' %');
                    $('#wcs').text(r.card.solved);
                    $('#pwcs').text(r.persentage.solved + ' %');
                    $('#wcun').text(r.card.unsolved);
                    $('#pwcun').text(r.persentage.unsolved + ' %');
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('api.email') }}",
                data: {
                    from_date: date,
                    to_date: date
                },
                dataType: "json",
                success: function(r) {
                    $('#es').text(r.card.solved);
                    $('#pes').text(r.persentage.solved + ' %');
                    $('#ei').text(r.card.message);
                    $('#pei').text(r.persentage.message + ' %');
                    $('#es').text(0);
                    $('#pes').text('0 %');
                }
            });
        }

        loadData($('#date-filter').val());

        $('#date-filter').change(function(e) {
            e.preventDefault();
            loadData($(this).val());
        });

        $(function() {
            $("#exporttable2").click(function(e) {
                var table = $(".datatable");
                if (table && table.length) {
                    $(table).table2excel({
                        exclude: ".noExl",
                        name: "<?php echo isset($description) ? $description : ucfirst($page); ?>",
                        filename: "Data <?php echo isset($description) ? $description : ucfirst($page); ?>".replace(/[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls"
                    });
                }
            });

            $("#exporttable22").click(function(e) {
                var table = $(".datatable22");
                if (table && table.length) {
                    $(table).table2excel({
                        exclude: ".noExl",
                        name: "<?php echo isset($description) ? $description : ucfirst($page); ?>",
                        filename: "Data <?php echo isset($description) ? $description : ucfirst($page); ?>".replace(/[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls"
                    });
                }
            });
        });

        function chart_(selector, data) {
            $(`#${selector}-p`).empty().html(`<div id="${selector}" style="height: 200px; width: 100%"></div>`);
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

        $('.btn-filter-tabsss').click(function(e) {
            var href = $(this).attr('href');
            if (href == "#tab_conversation") {
                $('.filter-appsss').show();
            } else {
                $('.filter-appsss').hide();
            }
        });
    </script>
@endpush

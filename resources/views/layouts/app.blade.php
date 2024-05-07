<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CRM Dashboard') }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/blue.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

    <link type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"> </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('OrgChart/src/css/jquery.orgchart.css') }}">
    <script src="{{ asset('OrgChart/src/js/jquery.orgchart.js') }}"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <script type="text/javascript">
        
        const confLanguage = {
            paginate: {
                next: '&#8594;',
                previous: '&#8592;'
            },
            emptyTable: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ baris data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 baris data",
            infoFiltered: "(Terfilter dari _MAX_ total baris data)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Filter per _MENU_",
            loadingRecords: "Loading...",
            processing: "",
            search: "Cari:",
            zeroRecords: "Data tidak ditemukan",
        };

    </script>
    
    <style>
        @media (max-width: 576px) {

            .mb-sm-3,
            .my-sm-3 {
                margin-bottom: 1rem !important;
            }
        }

        .input-group-text {
            color: #495057 !important;
            background-color: #e9ecef !important;
            border: 1px solid #cad1d7 !important;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            /* color: #525f7f; */
            border-color: transparent;
            border-bottom: 2px solid #2680EE !important;
            background-color: transparent !important;
        }

        /* ------------- */

        .icon-light {
            color: #a3a7ab;
        }

        .bg-light-primary {
            background-color: #bddfee !important;
        }

        .bg-light-success {
            background-color: #b2ecd3 !important;
        }

        .bg-light-danger {
            background-color: #f0b3be !important;
        }

        .bg-light-warning {
            background-color: #FFCD9F !important;
        }

        .round {
            border-radius: 10px;
        }
    </style>
    @yield('add-style')
</head>

<body class="{{ $class ?? '' }}">
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content mb-5">
        
        @include('layouts.navbars.navbar')

        @if ($message = Session::get('message'))
            <div class="container-fluid">
                <div class="alert alert-{{ $message[1] }}" role="alert">
                    {{ $message[0] }}
                </div>    
            </div>
        @endif

        @yield('content')

    </div>

    @guest()
        @include('layouts.footers.guest')
    @endguest

    <?php if(isset($description) || isset($page)){?>
    
    <script>
        $(function() {
            $("#exporttable").click(function(e) {
                var table = $("#htmltable");
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
    </script>

    <script>
        $(document).ready(function() {
            $('#htmltable').DataTable({
                "paging": false,
            });
            $('#datatable').DataTable({
                "paging": false
            });
            $('#datatable2').DataTable({
                "paging": false
            });
        });
    </script>
    <?php } else { ?>
  
    <?php } ?>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datatable').DataTable({
            language: confLanguage
        });

        $('.datatable2').DataTable({
            language: confLanguage
        });

        function inaDate(date, time = false) {
            const today = new Date(date);
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // Months start at 0!
            let dd = today.getDate();

            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;

            return dd + '-' + mm + '-' + yyyy + `${time ? ` | ${today.getHours()}:${today.getMinutes()}` : ``}`;
        }

        function get_percentage(total, number) {
            if (total > 0) {
                // return ((number * 100) / total).toFixed(3);
                return Math.round((number * 100) / total);
            } else {
                return 0;
            }
        }

       
    </script>

    @stack('js')
    @yield('js')
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    @stack('js2')

    <script>
        setInterval(() => {
            var a = ['d', 'm', 'y'];
            a.map(v => {
                if ($(`#dmy-${v}-percent`).text().indexOf('-') > -1) {
                    $(`#dmy-${v}-percent`).closest('.text-success').children('i').removeClass('fa-arrow-up')
                        .addClass('fa-arrow-down');
                    $(`#dmy-${v}-percent`).closest('.text-success').removeClass('text-success').addClass(
                        'text-danger');
                    // $(`#dmy-${v}-percent`).closest('.fa-arrow-up').removeClass('fa-arrow-up').addClass('fa-arrow-down');
                }
            })

            var a = ['likes', 'comments', 'message', 'read', 'unread', 'solved', 'unsolved', 'sent-email', 'inbox',
                'spam', 'read-message', 'unread-message', 'total-conversations', '', 'total-sent-message',
                'total-incoming-call', 'solved-conversations', 'unsolved-conversations', 'total-user',
                'incoming', 'missed', 'hold'
            ];
            a.map(v => {
                if ($(`#p${v}`).text().indexOf('-') > -1) {
                    $(`#p${v}`).closest('.text-success').children('i').removeClass('fa-arrow-up').addClass(
                        'fa-arrow-down');
                    $(`#p${v}`).closest('.text-success').removeClass('text-success').addClass(
                        'text-danger');
                    // $(`#p${v}`).closest('.fa-arrow-up').removeClass('fa-arrow-up').addClass('fa-arrow-down');
                }
            })
        }, 1000);
    </script>
</body>

</html>

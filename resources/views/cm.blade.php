@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-cm')
    <div class="container-fluid">
        <div class="row my-3 justify-content-between">
            <div class="col-md-4 d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <h2 class="m-0">Filter</h2>
                    {{-- <select class="form-control">
                        <option>Name</option>
                        <option selected>Phone Number</option>
                        <option>Channel</option> --}}
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="d-flex">
                    <input type="date" class="form-control date-filter" id="from" value="<?= date('Y-m-d') ?>">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control date-filter" id="to" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>Data</h2>
                            <button id="exporttable2" class="btn btn-primary">Export</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Name</th>
                                        <th>Channel</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        {{-- <th>Address</th> --}}
                                        {{-- <th>Agent</th> --}}
                                        <th>Created</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="cm-tbody">
                                </tbody>
                            </table>
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
        });

        function loadData() {
            $.ajax({
                type: "get",
                url: "{{ route('api.cm') }}",
                data: {
                    from_date: $('#from').val(),
                    to_date: $('#to').val()
                },
                dataType: "json",
                success: function(r) {
                    $('.datatable').DataTable().clear().destroy();
                    var html = ``;
                    $.each(r.data, function(i, v) {
                        html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td>${v.Name}</td>
                                <td>${v.Channel}</td>
                                <td>${v['Phone Number'] ? v['Phone Number'] : '-'}</td>
                                <td>${v.Email ? v.Email : '-'}</td>
                                <td>${v.Username ? v.Username : '-'}</td>
                                <td>${inaDate(v['Created At'])}</td>
                                <td>${v.Solved == true ? '<div class="text-success btn-sm">Solved</div>' : '<div class="text-danger btn-sm">Unsolved</div>'}</td>
                            </tr>
                    `;
                    });
                    $(`#cm-tbody`).html(html);
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
        }

        loadData();

        $('.date-filter').change(function(e) {
            e.preventDefault();
            loadData();
        });
    </script>
@endpush

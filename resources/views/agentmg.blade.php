@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-agentmg')

    <div class="container-fluid mt--9">
        <div class="row mb-2">
            <div class="col text-right">
                <button id="exporttable" class="btn btn-primary" style="margin-left: 20px;">Export</button>
                <a href="#" class="btn btn-success" style="margin-left: 20px;">+ Create Division</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="htmltable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Department</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Agent</th>
                                        <th scope="col">Role Channel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Production</th>
                                        <td>IT</td>
                                        <td>1</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Marcomm</th>
                                        <td>Graphic Design</td>
                                        <td>3</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sales</th>
                                        <td>Business Development</td>
                                        <td>2</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Management</th>
                                        <td>Human Resource</td>
                                        <td>1</td>
                                        <td>2</td>
                                    </tr>
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

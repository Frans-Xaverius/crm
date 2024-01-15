@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-accountmg')

    <div class="container-fluid mt--9">
        <div class="row mb-2">
            <div class="col text-right">
                <button id="exporttable" class="btn btn-primary" style="margin-left: 20px;">Export</button>
                <a href="#" class="btn btn-success" style="margin-left: 20px;">+ Create User</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-body">
                        <div style="margin-top: 10px" class="table-responsive">
                            <table id="htmltable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Channel</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Agent</th>
                                        <th scope="col">Created</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Imam</th>
                                        <td>Instagram</td>
                                        <td>0812 3456 789</td>
                                        <td>mimamnuro@gmail.com</td>
                                        <td>Jakarta, Indonesia</td>
                                        <td class="text-center">1</td>
                                        <td><?php echo date('Y-m-d h:s'); ?></td>
                                        <td class="text-success">Active</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adi</th>
                                        <td>Instagram</td>
                                        <td>0812 3456 789</td>
                                        <td>mimamnuro@gmail.com</td>
                                        <td>Jakarta, Indonesia</td>
                                        <td class="text-center">2</td>
                                        <td><?php echo date('Y-m-d h:s'); ?></td>
                                        <td class="text-success">Active</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jimi</th>
                                        <td>Instagram</td>
                                        <td>0812 3456 789</td>
                                        <td>mimamnuro@gmail.com</td>
                                        <td>Jakarta, Indonesia</td>
                                        <td class="text-center">1</td>
                                        <td><?php echo date('Y-m-d h:s'); ?></td>
                                        <td class="text-success">Active</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Budi</th>
                                        <td>Facebook</td>
                                        <td>0812 3456 789</td>
                                        <td>mimamnuro@gmail.com</td>
                                        <td>Jakarta, Indonesia</td>
                                        <td class="text-center">4</td>
                                        <td><?php echo date('Y-m-d h:s'); ?></td>
                                        <td class="text-danger">Suspend</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Mandra</th>
                                        <td>WhatsApp</td>
                                        <td>0812 3456 789</td>
                                        <td>mimamnuro@gmail.com</td>
                                        <td>Jakarta, Indonesia</td>
                                        <td class="text-center">3</td>
                                        <td><?php echo date('Y-m-d h:s'); ?></td>
                                        <td class="text-success">Active</td>
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

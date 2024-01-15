@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-accountmg')

    <div class="container-fluid mt--9">
        <div class="row mb-2">
            <div class="col text-right">
                {{-- <button id="exporttable" class="btn btn-primary" style="margin-left: 20px;">Export</button> --}}
                <a href="{{ route('setting.accountmanagement.add') }}" class="btn btn-success" style="margin-left: 20px;">+
                    Create Account</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" width="1%" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>
                                                @if (!in_array($v->role, ['supervisor']))
                                                    <a href="{{ route('setting.accountmanagement.edit', $v->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('setting.accountmanagement.delete', $v->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $v->name }}</td>
                                            <td>{{ $v->email }}</td>
                                            <td>{{ $v->phone }}</td>
                                            <td>{{ !in_array($v->role, ['supervisor']) ? ($v->Department ? $v->Department->name : '') : '' }}</td>
                                            <td>{{ $role[$v->role] }}</td>
                                        </tr>
                                    @endforeach
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

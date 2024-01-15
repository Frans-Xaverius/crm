@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-tag')

    <div class="container-fluid mt--9">
        <div class="row mb-2">
            <div class="col text-right">
                <a href="{{ route('tag.add') }}" class="btn btn-success" style="margin-left: 20px;">+
                    Create Tag</a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>
                                                <a href="{{ route('tag.edit', $v->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <a href="{{ route('tag.delete', $v->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure ?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                            <td>{{ $v->name }}</td>
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

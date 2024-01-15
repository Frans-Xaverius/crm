@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-agentmg')
    
    <div class="container-fluid mt--9">
        <div class="row mb-2">
            <div class="col text-right">
                {{-- <button id="exporttable" class="btn btn-primary" style="margin-left: 20px;">Export</button> --}}
                <a href="{{ route('setting.agentmanagement.add') }}" class="btn btn-success" style="margin-left: 20px;">+ Create Division</a>
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
                                        <th scope="col">Department</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Agent</th>
                                        {{-- <th scope="col">status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>
                                                {{-- @if (!in_array($v->name, ['Sosmed'])) --}}
                                                    <a href="{{ route('setting.agentmanagement.edit', $v->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('setting.agentmanagement.delete', $v->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                {{-- @endif --}}
                                            </td>
                                            <td>{{ $v->department }}</td>
                                            <td>{{ $v->name }}</td>
                                            <td>{{ $v->Users->count() }}</td>
                                            {{-- <td>{!! !empty($v->q_id) ? '<span class="badge badge-pill badge-success">Actice</span>' : '<span class="badge badge-pill badge-danger">Non Actice</span>' !!}</td> --}}
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
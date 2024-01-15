@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-agentmg')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow mt-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ !empty($id) ? route('setting.accountmanagement.edit-p', $id) : route('setting.accountmanagement.add-p') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name *</label>
                                    <input class="form-control" type="text" name="name" required value="{{ !empty($id) ? $data->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Email *</label>
                                    <input class="form-control" type="email" name="email" required value="{{ !empty($id) ? $data->email : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Password {{ empty($id) ? '*' : '' }}</label>
                                    <input class="form-control" type="password" name="password" {{ empty($id) ? 'required' : '' }}>
                                </div>
                                <div class="form-group">
                                    <label for="">Phone *</label>
                                    <input class="form-control" type="text" name="phone" required value="{{ !empty($id) ? $data->phone : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">SSO</label>
                                    <input class="form-control" type="text" name="sso" value="{{ !empty($id) ? $data->sso : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Divisi</label>
                                    <select class="form-control" type="text" name="department_id">
                                        <option value="">-- Select --</option>
                                        @foreach ($divisi as $k => $v)
                                            <option value="{{ $k }}" {{ !empty($id) ? ($data->department_id == $k ? 'selected' : '') : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Role *</label>
                                    <select class="form-control" type="text" name="role" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($role as $k => $v)
                                            <option value="{{ $k }}" {{ !empty($id) ? ($data->role == $k ? 'selected' : '') : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
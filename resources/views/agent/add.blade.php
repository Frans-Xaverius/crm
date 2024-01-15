@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-agentmg')

    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow mt-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form
                                action="{{ !empty($id) ? route('setting.agentmanagement.edit-p', $id) : route('setting.agentmanagement.add-p') }}"
                                method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Department</label>
                                    <input class="form-control" type="text" name="department" required
                                        value="{{ !empty($id) ? $data->department : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Division</label>
                                    <input class="form-control" type="text" name="name" required
                                        value="{{ !empty($id) ? $data->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Application</label>
                                    <br>
                                    @foreach ($app as $k => $v)
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="check{{ $k }}">
                                                <input type="checkbox" class="form-check-input" id="check{{ $k }}"
                                                    name="app[]" value="{{ $k }}" {{ !empty($id) && in_array($k, json_decode($data->app)) ? 'checked' : '' }}> {{ $v }}
                                            </label>
                                        </div>
                                    @endforeach
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

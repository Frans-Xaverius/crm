@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-tag')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow mt-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ !empty($id) ? route('tag.edit-p', $id) : route('tag.add-p') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name *</label>
                                    <input class="form-control" type="text" name="name" required value="{{ !empty($id) ? $data->name : '' }}">
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
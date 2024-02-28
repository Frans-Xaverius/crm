@extends('layouts.app')

@section('content')

    <div class="container-fluid pb-1 pt-3 pt-md-7">
        <div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
            <div class="row mb-5">
                <div class="col-md-7">
                    <h3> Daftar Pertanyaan </h3>
                </div>
                <div class="col-md-5">
                    <div class="d-flex flex-row justify-content-end">
                        <div class="btn-group">
                            <a class="btn btn-primary" href="{{ route('pertanyaan.add') }}"> Tambah </a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="datatable table table-pertanyaan">
                <thead>
                    <tr>
                        <th> Level </th>
                        <th> Pertanyaan </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pertanyaan as $p)
                    <tr>
                        <td> {{ $p->level }} </td>
                        <td> {{ $p->content }} </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-warning" href="{{ route('pertanyaan.edit') }}?id={{ $p->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="btn btn-success" href="{{ route('pertanyaan.manage') }}?id={{ $p->id }}">
                                    <i class="bi bi-diagram-2-fill"></i>
                                </a>
                                <button class="btn btn-danger do-delete" attr-id="{{ $p->id }}">
                                    <i class="bi bi-trash"> </i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form method="POST" class="delete-form" action="{{ route('pertanyaan.delete') }}">
        @csrf
        <input type="hidden" name="id">
    </form>

   
@endsection

@push('js')
    @include('pertanyaan.script')
@endpush
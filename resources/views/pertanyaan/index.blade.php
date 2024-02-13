@extends('layouts.app')

@section('content')

    <div class="container-fluid pb-1 pt-3 pt-md-7">
        <div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
            <table class="datatable table">
                <thead>
                    <tr>
                        <th> Level </th>
                        <th> Pertanyaan </th>
                        <th> Jawaban </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pertanyaan as $p)
                    <tr>
                        <td> {{ $p->level }} </td>
                        <td> {{ $p->content }} </td>
                        <td> {{ $p->jawaban }} </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning"> Edit </button>
                                <button class="btn btn-danger"> Delete </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   
@endsection

@push('js')
    @include('pertanyaan.script')
@endpush
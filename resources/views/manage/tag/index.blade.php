@extends('layouts.app')

@section('content')
	
	<div class="container-fluid pt-md-1">
		<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
            <div class="row">
                <div class="col">
                    <button href="/" class="btn btn-info mb-4 btn-sm do-add" style="float: right;"> Tambah Tag </button>
                </div>
            </div>
            <table class="datatable table table-tag">
                <thead>
                    <tr>
                    	<th width="10%"> No </th>
                    	<th> Tag </th>
                        <th width="15%"> Action </th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($tags as $k => $t)
                		<tr>
                			<td> {{ $k + 1 }} </td>
                			<td> {{ $t->name }} </td>
                			<td>
	                			<div class="btn-group btn-group-sm">
	                        		<button class="btn btn-warning do-edit" attr-dt="{{ json_encode($t) }}"> <i class="bi bi-pencil"> </i> </button>
	                        		<button class="btn btn-danger do-delete" attr-dt="{{ $t->id }}"> <i class="bi bi-trash"> </i> </button>
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
    @include('manage.tag.script')
@endpush
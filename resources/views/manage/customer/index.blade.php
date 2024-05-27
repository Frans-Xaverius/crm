@extends('layouts.app')

@section('content')

	<div class="container-fluid pt-md-1">
		<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
            <table class="datatable table table-tag">
                <thead>
                    <tr>
                    	<th width="7.5%"> No </th>
                    	<th> Nomor HP </th>
                    	<th> Nama </th>
                    	<th> Bot </th>
                        <th width="10%"> Action </th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($customer as $k => $c)
                		<tr>
                			<td> {{ $k + 1 }} </td>
                			<td> {{ $c->no_telp }} </td>
                			<td> {{ $c->nama }} </td>
                			<td> {{ $c->is_bot }} </td>
                			<td>
	                			<div class="btn-group btn-group-sm">
	                        		<button class="btn btn-warning do-edit" attr-dt="{{ json_encode($c) }}"> <i class="bi bi-pencil"> </i> </button>
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
    @include('manage.customer.script')
@endpush
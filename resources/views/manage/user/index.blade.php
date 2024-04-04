@extends('layouts.app')

@section('content')
	
	<div class="container-fluid pt-md-1">
		<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
			<table class="datatable table table-users">
                <thead>
                    <tr>
                    	<th width="6%"> No </th>
                    	<th> Username </th>
                        <th> Department </th>
                        <td> Role </td>
                        <th width="10%"> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $k => $u)
                    <tr>
                        <td> {{ $k + 1 }} </td>
                        <td> {{ $u->name }} </td>
                        <td> {{ $u->Department->name }} </td>
                        <td> {{ $u->detailRole->name }} </td>
                        <td>
                        	<div class="btn-group btn-group-sm">
                        		<button class="btn btn-warning do-edit" attr-dt="{{ json_encode($u) }}"> <i class="bi bi-pencil"> </i> </button>
                        		<button class="btn btn-danger do-delete" attr-dt="{{ json_encode($u) }}"> <i class="bi bi-trash"> </i> </button>
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
    @include('manage.user.script')
@endpush
@extends('layouts.app')

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-1">
	<div class="mt-3 card bg-white shadow" style="padding: 2.5%;">
		<table class="datatable table table-log">
			<thead>
				<tr>
					<th> Customer </th>
					<th> Eskalasi </th>
					<th> Tag </th>
					<th> Rating </th>
					<th width="5%"> Action </th>
				</tr>
			</thead>
			<tbody>
				@foreach ($conversation as $c)
				<tr>
					<td> {{ $c->customer->no_telp }} </td>
					<td> {{ $c->user->name ?? 'Tidak ditentukan' }} </td>
					<td> {{ $c->tags->pluck('detail')->pluck('name') }} </td>
					<td> {{ $c->rate }} </td>
					<td>
						<button class="btn btn-info btn-sm"><i class="bi bi-box-arrow-up-right"></i></button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@push('js')
	@include('laporan.whatsapp.script')
@endpush

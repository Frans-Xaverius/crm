@extends('layouts.app')

@section('content')

<div class="container-fluid pt-md-1">
	<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
		<div class="row mb-4">
			<div class="col">
				<h3> Instagram </h3>
			</div>
			<div class="col">
				<div  style="float: right;">
					<a href="{{ $refreshUrl }}" class="btn btn-primary btn-sm"> Refresh </a>
				</div>
			</div>
		</div>
		
		@if(!empty($response->data))
			<table class="datatable table table-tag">
				<thead>
					<tr>
						<th width="5%"> No </th>
						<th> Tanggal </th>
						<th> Caption </th>
						<th> Komentar </th>
						<th> Like </th>
						<th width="8%"> URL </th> 
					</tr>
				</thead>
				<tbody>
					@foreach ($response->data as $k => $d)
					<tr>
						<td> {{ $k + 1 }} </td>
						<td> {{ date("Y-m-d H:i:s", strtotime($d->timestamp)) }} </td>
						<td> {{ $d->caption }} </td>
						<td> {{ $d->likes_count }} </td>
						<td> {{ $d->comments_count }} </td>
						<td>
							<button class="btn btn-sm btn-info do-note">
								<a class="bi bi-box-arrow-up-right" href="{{ $d->media_url }}"> </a>
							</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif

	</div>
</div>

@endsection

@push('js')
	@include('media.instagram.script')
@endpush
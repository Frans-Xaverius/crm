@extends('layouts.app')

@section('content')

<div class="container-fluid pt-md-1">
	<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
		
		<div class="row mb-4">
			<div class="col">
				<h3> Daftar panggilan untuk tanggal {{ date("d/m/Y") }} </h3>
			</div>
		</div>

		<table class="datatable table table-tag">
			<thead>
				<tr>
					<th width="5%"> No </th>
					<th> Jam </th>
					<th> Nomor </th>
					<th> Respon </th>
					<th> Durasi </th>
					<th width="8%"> Action </th> 
				</tr>
			</thead>
			<tbody>
				@foreach ($cdr as $k => $c)
					<tr class="{{ ((strtolower($c->disposition) == 'answered') && (!$c->pabx)) ? 'bg-warning text-white' : '' }}">
						<th> {{ $k + 1 }} </th>
						<th> {{ date("h:i:s", strtotime($c->calldate)) }} </th>
						<th> {{ $c->src }} </th>
						<th> {{ $c->disposition }} </th>
						<th> {{ $c->duration }} </th>
						<th>
							<button class="btn btn-sm btn-info do-note" attr-dt="{{ json_encode($c) }}" attr-ct="{!! ($c->pabx->catatan) ?? '' !!}">
								<i class="bi bi-pencil"></i>
							</button>
						</th>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

@endsection

@push('js')
	@include('media.pabx.script')
@endpush
@extends('layouts.app')

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-1">
	<div class="mt-3 mb-4 card bg-white shadow" style="padding: 2.5%">
		<div class="row">
			<div class="col-md-6">
				<div class="form-grup">
					<label> Bulan </label>
					<select class="form-select form-select-sm form-control val-month">
						@foreach ($month as $k => $m)
							<option value="{{ $k + 1 }}"> {{ $m }} </option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-grup">
					<label> Tahun </label>
					<select class="form-select form-select-sm form-control val-year">
						@for ($i = Date('Y'); $i > Date('Y') - 50; $i--)
							<option value="{{ $i }}"> {{ $i }} </option>
						@endfor
					</select>
				</div>
			</div>
		</div>
		<div class="d-flex flex-row justify-content-end">
			<div class="btn-group mt-3">
				<button class="btn btn-primary do-search btn-sm"> Cari </button>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid pb-1 pt-3 pt-md-1">
	<div class="mt-3 card bg-white shadow" style="padding: 2.5%">
		<div class="row mb-3">
			<div class="col">
				<div id="tagChart"></div>
			</div>
			<div class="col">
				<div id="eskalasiChart"></div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<div id="line"></div>
			</div>
		</div>
	</div>
</div>

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
					<td> {{ $c->customer->nama ?? $c->customer->no_telp }} </td>
					<td> {{ $c->user->name ?? 'Tidak ditentukan' }} </td>
					<td> {{ $c->tags->pluck('detail')->pluck('name') }} </td>
					<td> {{ $c->rate }} </td>
					<td>
						<a href="{{ route('laporan.whatsapp.chat') }}?id={{ $c->id }}" class="btn btn-info btn-sm do-riwayat">
							<i class="bi bi-box-arrow-up-right"></i>
						</a>
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

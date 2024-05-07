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
				<button class="btn btn-primary do-search"> Cari </button>
			</div>
		</div>
	</div>

	<div class="mt-3 card bg-white shadow" style="padding: 2.5%">
		<div class="row mb-3">
			<div class="col">
				<div id="pie"></div>
			</div>
			<div class="col">
				<div id="pie2"></div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<div id="line"></div>
			</div>
		</div>
	</div>

	<div class="mt-3 card bg-white shadow" style="padding: 2.5%;">
		<table class="datatable table table-log">
			<thead>
				<tr>
					<th> Tanggal </th>
					<th> Jam </th>
					<th> Nomor </th>
					<th> Respon </th>
					<th> Durasi </th>
					<th width="5%"> Catatan </th>
				</tr>
			</thead>
			<tbody>
				@foreach ($cdr as $c)
					<tr>
						<th> {{ date("d/m/Y", strtotime($c->calldate)) }} </th>
						<th> {{ date("h:i:s", strtotime($c->calldate)) }} </th>
						<th> {{ $c->src }} </th>
						<th> {{ $c->disposition }} </th>
						<th> {{ $c->duration }} </th>
						<th>
							@if ($c->pabx)
								<button class="btn btn-info btn-sm do-show" attr-ctt="{!! $c->pabx->catatan ?? '-' !!}"> Detail </button>
							@else
								<button class="btn btn-danger btn-sm" disabled> Tidak Ada </button>
							@endif
						</th>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@push('js')
	@include('laporan.log-panggilan.script')
@endpush

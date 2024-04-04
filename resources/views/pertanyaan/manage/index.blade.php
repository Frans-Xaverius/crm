@extends('layouts.app')

@section('add-style')
	<style type="text/css">
		
		.orgchart .node .content {
			height: auto !important;
			text-wrap: balance !important;
		}

	</style>
@endsection

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-1">
	<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
		<div class="row mb-5">
			<div class="col-md-7">
				<h3> Daftar Pertanyaan </h3>
			</div>
			<div class="col-md-5">
				<div class="d-flex flex-row justify-content-end">
					<div class="btn-group btn-group-sm">
						<button class="btn btn-info do-add"> Tambah </button>
						<button class="btn btn-primary do-edit"> Edit </button>
						<button class="btn btn-danger do-delete"> Hapus </button>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center">
			<div class="chart-container"></div>
		</div>
		
	</div>
</div>


@endsection

@push('js')
	@include('pertanyaan.manage.script')
@endpush
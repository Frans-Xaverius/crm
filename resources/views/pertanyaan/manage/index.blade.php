@extends('layouts.app')

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-7">
	<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
		<div class="row mb-5">
			<div class="col-md-7">
				<h3> Daftar Pertanyaan </h3>
			</div>
			<div class="col-md-5">
				<div class="d-flex flex-row justify-content-end">
					<div class="btn-group">
						<a class="btn btn-primary" href="{{ route('pertanyaan.add') }}"> Tambah </a>
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
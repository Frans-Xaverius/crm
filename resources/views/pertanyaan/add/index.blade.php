@extends('layouts.app')

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-7">
	<div class="mt-2 card bg-white shadow" style="padding: 2.5%;">
		<form method="POST" action="{{ route('pertanyaan.submit') }}" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label> Parent </label>
						<select class="form-control" name="parent" required>
							<option disabled selected> -- Pilih -- </option>
							@foreach ($parent as $p)
								<option value="{{ $p->id }}"> {{ $p->content }} </option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label> Pertanyaan </label>
						<textarea rows="4" name="pertanyaan" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label> Jawaban </label>
						<textarea rows="4" name="jawaban" class="form-control"></textarea>
					</div>
				</div>
			</div>
			<div class="d-flex flex-row justify-content-end">
				<div class="btn-group">
					<button class="btn btn-primary" type="submit"> Simpan </button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@push('js')
    @include('pertanyaan.add.script')
@endpush
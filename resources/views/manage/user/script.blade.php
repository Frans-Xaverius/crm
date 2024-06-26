<script type="text/javascript">
	
	$('.table-users tbody').on('click', '.do-edit', function () {

		let dt = JSON.parse($(this).attr('attr-dt'));
		Swal.fire({

          	title: "Edit Form",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="update-form text-left pr-4 pl-4" action="{{ route('manage.user.update') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" class="form-control" name="id" value="${dt.id}" />
          			<div class="form-group mt-3">
          				<label> Role </label>
          				<select class="form-control form-control-sm par-select" name="role">
          					<option selected disabled> -- Pilih -- </option>
          					@foreach($role as $r)
          						<option value="{{ $r->id }}">{{ $r->name }}</option>
          					@endforeach
          				</select>
          			</div>
          			<div class="form-group mt-3">
          				<label> Department </label>
          				<select class="form-control form-control-sm par-select" name="department_id">
          					<option selected disabled> -- Pilih -- </option>
          					@foreach($department as $d)
          						<option value="{{ $d->id }}">{{ $d->name }}</option>
          					@endforeach
          				</select>
          			</div>
				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
          	didOpen: () => {

          		$('[name=role]').val(dt.role);
          		$('[name=department_id]').val(dt.department_id);

          		$('.par-select').select2({
					dropdownParent: $('.swal2-container'),
				});
          	},
          	width: '50em',
        }).

        then((result) => {
        	if (result.value) {
        		$('.update-form').submit();
        	}
        })

	});

	$('.table-users tbody').on('click', '.do-delete', function () {

		let dt = JSON.parse($(this).attr('attr-dt'));

		Swal.fire({
			title: 'Konfirmasi',
			icon: 'warning',
			html: `
          		<form method="POST" class="delete-form text-left p-2" action="{{ route('manage.user.delete') }}" enctype="multipart/form-data">
          			@csrf
          			<h3 class="text-center"> Apakah anda akan menghapus user ini? </h3>
          			<input type="hidden" class="form-control" name="id" value="${dt.id}" />
				</form>
          	`,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
		}).
		then((result) => {
			if (result.value) {
				$('.delete-form').submit();
			}
		});
		
	});

</script>
<script type="text/javascript">
	
	$('.table-tag tbody').on('click', '.do-delete', function () {

		let id = $(this).attr('attr-dt');

		Swal.fire({
			title: 'Konfirmasi',
			icon: 'warning',
			html: `
          		<form method="POST" class="delete-form text-left p-2" action="{{ route('manage.tag.delete') }}" enctype="multipart/form-data">
          			@csrf
          			<h3 class="text-center"> Apakah anda akan menghapus tag ini? </h3>
          			<input type="hidden" class="form-control" name="id" value="${id}" />
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

	$('.do-add').on('click', function(){

		Swal.fire({
			title: 'Input Data',
			icon: 'question',
			html: `
          		<form method="POST" class="add-form text-left p-2" action="{{ route('manage.tag.add') }}" enctype="multipart/form-data">
          			@csrf
          			<div class="form-group">
						<label> Nama </label>
						<input type="text" name="nama" class="form-control">
					</div>
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
				$('.add-form').submit();
			}
		});

	});

	$('.table-tag tbody').on('click', '.do-edit', function () {

		let dt = JSON.parse($(this).attr('attr-dt'));

		Swal.fire({

          	title: "Edit Tag",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="update-form text-left pr-4 pl-4" action="{{ route('manage.tag.update') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" class="form-control" name="id" value="${dt.id}" />
          			<div class="form-group">
						<label> Nama </label>
						<input type="text" name="nama" class="form-control" value="${dt.name}">
					</div>
				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
        }).

        then((result) => {
        	if (result.value) {
        		$('.update-form').submit();
        	}
        });
	});

</script>
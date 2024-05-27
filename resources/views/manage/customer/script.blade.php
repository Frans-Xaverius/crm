<script type="text/javascript">
	
	$('.table-tag').on('click', '.do-edit', function(){

		let dt = JSON.parse($(this).attr('attr-dt'));

		Swal.fire({
			title: 'Edit Customer',
			icon: 'question',
			html: `
          		<form method="POST" class="update-form text-left p-2" action="{{ route('manage.customer.update') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" name="id" value="${dt.id}" />
          			<div class="form-group">
				        <label> Nama </label>
				        <input type="text" name="nama" class="form-control" value="${dt.nama}">
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
				$('.update-form').submit();
			}
		});

	});

</script>
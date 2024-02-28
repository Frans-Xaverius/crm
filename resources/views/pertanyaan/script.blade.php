<script type="text/javascript">

	$('.table-pertanyaan tbody').on('click', '.do-delete', function(){

		let id = $(this).attr('attr-id');

		Swal.fire({
			title: 'Konfirmasi',
			text: `Apakah anda akan menghapus pertanyaan ini?`,
			footer: `<i> Akan menghapus semua pertanyaan yang berhubungan dengan pertanyaan ini </i>`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
		}).
		then((result) => {
			if (result.value) {
				$('.delete-form [name=id]').val(id);
				$('.delete-form').submit();
			}
		});

	});
    
</script>
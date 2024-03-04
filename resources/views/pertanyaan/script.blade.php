<script type="text/javascript">

	$('.do-add').on('click', function(){
		Swal.fire({
          	title: "Tambah Topik Pertanyaan",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="append-form mt-3 text-left" action="{{ route('pertanyaan.submit') }}" enctype="multipart/form-data">
          			@csrf
          			<div class="form-group mt-3">
          				<input type="text" class="form-control" name="content" value="" />
          			</div>
				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
          	width: '45em',
        }).
        then((result) => {
        	if (result.value) {
        		$('.append-form').submit();
        	}
        })
    });

</script>
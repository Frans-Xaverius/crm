<script type="text/javascript">
	
	$('.table-tag').on('click', '.do-note', function () {
		
		let dt = JSON.parse($(this).attr('attr-dt'));

		Swal.fire({
          	title: "Tambah Form",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="append-form mt-3 text-left" action="{{ route('media.pabx.submit') }}" enctype="multipart/form-data">
          			@csrf

          			<input type="hidden" name="calldate" value="${dt.calldate}" />
          			<input type="hidden" name="number" value="${dt.src}" />
          			<input type="hidden" name="durasi" value="${dt.duration}" />
          			<input type="hidden" name="respon" value="${dt.disposition}" />

          			<div class="form-group">
						<label class="mb-3"> Catatan </label>
						<textarea name="catatan" class="form-control editor" rows="6"></textarea>
					</div>

				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
          	didOpen: () => {
          		ClassicEditor.create(document.querySelector('.editor'), {
          			toolbar: [ '|', 'bold', 'italic']
          		});
          	},
          	width: '60em',
        }).
        then((result) => {
        	if (result.value) {
        		$('.append-form').submit();
        	}
        });

	});

</script>
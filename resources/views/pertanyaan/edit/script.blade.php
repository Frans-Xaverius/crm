<script type="text/javascript">
	
	$(`[name=parent]`).on('change', function(){

		let val = $(this).val();
		$('textarea').prop('disabled', false);

		$.ajax({
			type: "GET",
			url: `{{ route('pertanyaan.get-child') }}?id=${val}`,
			success: function(dt) {

				let res = JSON.parse(dt);
				console.log(res);

				if (res.length > 1) {

					$('[name=jawaban]').prop('disabled', true);

				} else if (res.length == 1){

					if (res[0].jawaban != null) {
						$('textarea').prop('disabled', true);
					} else {
						$('[name=jawaban]').prop('disabled', true);
					}
				}
			}
		});

	});

	$(document).ready(function(){

		let currId = `{{ $data->id }}`;
		$('[name=parent]').val(currId).trigger('change');
			
		$('[name=parent]').select2();
		
	});

</script>
<script type="text/javascript">
	
	$('.form-select').select2();

	$('.do-search').on('click', function () {

		let url = `{{ route('laporan.log-panggilan') }}`;
		let bulan = $('.val-month').val();
		let tahun = $('.val-year').val();

		window.location.href = `${url}?month=${bulan}&year=${tahun}`;

	});

</script>
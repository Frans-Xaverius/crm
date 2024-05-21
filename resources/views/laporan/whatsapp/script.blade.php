<script type="text/javascript">
	
	$(document).ready(function(){
		const param = new URLSearchParams(window.location.search);

		$('.val-year').val(`{{ $currYear }}`);
		$('.val-month').val(`{{ $currMonth }}`);

		$('.form-select').select2();
	});

	$('.do-search').on('click', function () {

		let url = `{{ route('laporan.whatsapp') }}`;
		let bulan = $('.val-month').val();
		let tahun = $('.val-year').val();

		window.location.href = `${url}?month=${bulan}&year=${tahun}`;

	});

</script>

<script type="text/javascript">

	let dataTag = JSON.parse(`{!! json_encode($dataChart->tags) !!}`);
	let dataEskalasi = JSON.parse(`{!! json_encode($dataChart->eskalasi) !!}`);

	drawChart(dataTag, 'pie', 'Persentase Tag', 'tagChart', 'Jumlah Tag');
	drawChart(dataEskalasi, 'pie', 'Persentase Eskalasi', 'eskalasiChart', 'Jumlah Percakapan');

	function drawChart (data, type, judul, locId, namaSeries) {

		let arrObj = [];
		$.each(data, (k, v) => {
			arrObj.push({
				name: k,
				y: v
			});
		});
		
		Highcharts.chart(locId, {
		    chart: {
		        type: type,
		    },
		    title: {
		        text: judul,
		    },
		    tooltip: {
				valueSuffix: ''
			},
		    yAxis: {
		        min: 0,
		        title: {
		            text: 'X'
		        }
		    },
		    plotOptions: {
		    	pie: {
		    		allowPointSelect: true,
		    		cursor: 'pointer',
		    		dataLabels: {
		    			enabled: true,
		    			format: `
		    			<span style="text-transform: capitalize">
		    			<b>{point.name}</b>
		    			</span><br>
		    			<span style="opacity: 0.6"> {point.y} ({point.percentage:.1f}%) </span>
		    			`,
		    			connectorColor: 'rgba(128,128,128,0.5)'
		    		}
		    	}
		    },
		    series: [
		        {
		            name: namaSeries,
		            data: arrObj
		        },
		    ]
		});
	}

</script>
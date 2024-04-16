<script type="text/javascript">
	
	$(document).ready(function(){

		const param = new URLSearchParams(window.location.search);
		$('.val-year').val(param.get('year'));
		$('.val-month').val(param.get('month'));

		$('.form-select').select2();
	});

	$('.do-search').on('click', function () {

		let url = `{{ route('laporan.log-panggilan') }}`;
		let bulan = $('.val-month').val();
		let tahun = $('.val-year').val();

		window.location.href = `${url}?month=${bulan}&year=${tahun}`;

	});

</script>

<script type="text/javascript">

	let mainData = JSON.parse(`{!! $chartData !!}`);
	draw('pie', mainData.answer, '<i> Panggilan Terjawab </i>');
	draw('pie2', mainData.no_answer, '<i> Panggilan Tak Terjawab </i>');

	function draw (nameId, sourceData, subtxt) {

		let arrData = [];
		$.each(sourceData, (k,v) => {
			arrData.push({
				name: k,
				y: v
			});
		});

		Highcharts.chart(nameId, {
			chart: {
				type: 'pie'
			},
			title: {
				text: 'Frekuensi Panggilan Harian'
			},
			tooltip: {
				valueSuffix: ''
			},
			subtitle: {
		        text: subtxt
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
					name: 'Jumlah Panggilan',
					colorByPoint: true,
					data: arrData
				}
			]
		});
	}

</script>

<script type="text/javascript">

	let mainDt = JSON.parse(`{!! $duration !!}`);
	let dataX = [];
	let dataY = [];

	$.each(mainDt, (k,v) => {
		dataX.push(v.date);
		dataY.push(parseFloat(parseFloat(v.min / 60).toFixed(2)));
	});
	
	Highcharts.chart('line', {
	    chart: {
	        type: 'line'
	    },
	    title: {
	        text: 'Durasi Panggilan'
	    },
	    xAxis: {
	        categories: dataX,
	        title: {
	        	text: 'Tanggal'
	        }
	    },
	    yAxis: {
	        title: {
	            text: 'Jam'
	        }
	    },
	    plotOptions: {
	        line: {
	            dataLabels: {
	                enabled: true
	            },
	            enableMouseTracking: false
	        }
	    },
	    series: [{
	        name: 'Durasi Panggilan',
	        data: dataY
	    }]
	});


</script>
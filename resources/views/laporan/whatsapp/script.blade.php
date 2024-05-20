<script type="text/javascript">

	let data = JSON.parse(`{!! json_encode($dataChart->tags) !!}`);
	let arrObj = [];

	$.each(data, (k, v) => {
		arrObj.push({
			name: k,
			y: v
		});
	});
	
	Highcharts.chart('bar', {
	    chart: {
	        type: 'pie'
	    },
	    title: {
	        text: 'Tag',
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
	            name: 'Jumlah tag',
	            data: arrObj
	        },
	    ]
	});

</script>
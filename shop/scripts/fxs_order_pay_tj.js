function show_chart(chart_title, x_title, y_title, chart_categories, chart_data){
	for (var i = 0; i < chart_data.length; i++) {
		for (var j = 0; j < chart_data[i].data.length; j++) {
			chart_data[i].data[j] = Number(chart_data[i].data[j]);
		}
	}
	$('#container').highcharts({
        title: {
            text: chart_title,
            x: -20 //center
        },
        xAxis: {
        	title:{
        		text: x_title
        	},
            categories: chart_categories
        },
        yAxis: {
            title: {
                text: y_title
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: chart_data
    });
}

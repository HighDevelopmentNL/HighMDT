var series = {
	"monthDataSeries1": {
		"prices": [
			8107.85,
			8128.0,
			8122.9,
			8165.5,
			8340.7,
			8423.7,
			8423.5,
			8514.3,
			8481.85,
			8487.7,
			8506.9,
			8626.2,
			8668.95,
			8602.3,
			8607.55,
			8512.9,
			8496.25,
			8600.65,
			8881.1,
			9340.85
		],
			"dates": [
			"13 Nov 2017",
			"14 Nov 2017",
			"15 Nov 2017",
			"16 Nov 2017",
			"17 Nov 2017",
			"20 Nov 2017",
			"21 Nov 2017",
			"22 Nov 2017",
			"23 Nov 2017",
			"24 Nov 2017",
			"27 Nov 2017",
			"28 Nov 2017",
			"29 Nov 2017",
			"30 Nov 2017",
			"01 Dec 2017",
			"04 Dec 2017",
			"05 Dec 2017",
			"06 Dec 2017",
			"07 Dec 2017",
			"08 Dec 2017"
		]
	}
}













var options = {
	annotations: {
		yaxis: [{
			y: 8200,
			borderColor: '#00E396',
			label: {
				borderColor: '#00E396',
				style: {
					color: '#fff',
					background: '#00E396',
				},
				text: 'Support',
			}
		}],
		xaxis: [{
			x: new Date('23 Nov 2017').getTime(),
			strokeDashArray: 0,
			borderColor: '#775DD0',
			label: {
				borderColor: '#775DD0',
				style: {
					color: '#fff',
					background: '#775DD0',
				},
				text: 'Anno Test',
			}
		}, {
		x: new Date('03 Dec 2017').getTime(),
		borderColor: '#FEB019',
		label: {
			borderColor: '#FEB019',
			style: {
				color: '#fff',
				background: '#FEB019',
			},
				orientation: 'horizontal',
				text: 'New Beginning',
			}
		}],
		points: [{
			x: new Date('27 Nov 2017').getTime(),
			y: 8506.9,
			marker: {
				size: 8,
				fillColor: '#fff',
				strokeColor: 'red',
				radius: 2
			},
			label: {
				borderColor: '#FF4560',
				offsetY: 0,
				style: {
					color: '#fff',
					background: '#FF4560',
				},
				text: 'Point Annotation',
			} 
		}]
	},
	chart: {
		height: 280,
		type: 'line',
		id: 'areachart-2',
		toolbar: {
			show: false,
		},
	},
	dataLabels: {
		enabled: false
	},
	stroke: {
		curve: 'straight'
	},
	grid: {
		padding: {
			right: 30,
			left: 20
		}
	},
	series: [{
		data: series.monthDataSeries1.prices
	}],
	labels: series.monthDataSeries1.dates,
	xaxis: {
		type: 'datetime',
	},
}

var chart = new ApexCharts(
document.querySelector("#lineChartWithAnnotations"),
options
);

chart.render();
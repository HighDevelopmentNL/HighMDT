// var options = {
// 	chart: {
// 		height: 350,
// 		type: 'area',
// 		toolbar: {
// 			show: false,
// 		},
// 	},
// 	dataLabels: {
// 		enabled: false
// 	},
// 	grid: {
// 		show: false,
// 	},
// 	stroke: {
// 		curve: 'straight',
// 		show: true,
// 		lineCap: 'butt',
// 		colors: undefined,
// 		width: 2,
// 		dashArray: 0, 
// 	},
// 	series: [{
// 		name: 'Sales',
// 		data: [10, 15, 17, 19, 17, 15, 17, 19, 21, 23, 25, 27, 25, 23, 25, 21, 19, 21, 23, 25, 27, 25, 27, 29, 31, 33, 35, 31, 33, 35, 37, 39, 37, 35, 33, 35, 37, 39, 41, 43, 41, 39, 37, 35, 33, 31, 33, 35, 37, 39, 41, 43, 45, 43, 41, 43, 45, 47, 45, 43]
// 	}],
// 	theme: {
// 		monochrome: {
// 			enabled: true,
// 			color: '#67caf0',
// 			shadeIntensity: 0.1
// 		},
// 	},
// 	fill: {
// 		type: 'gradient',
// 		gradient: {
// 			shadeIntensity: 1,
// 			opacityFrom: 0.7,
// 			opacityTo: 0.9,
// 			stops: [0, 90, 100]
// 		}
// 	},
// 	xaxis: {
// 		categories: [
// 			"Jan",
// 			"Feb",
// 			"Mar",
// 			"Apr",
// 			"May",
// 			"Jun",
// 			"Jul",
// 			"Aug",
// 			"Sep",
// 			"Oct",
// 			"Nov",
// 			"Dec"
// 		],
// 	},
// }
// var chart = new ApexCharts(
// 	document.querySelector("#apexAreaChartBasic"),
// 	options
// );
// chart.render();



// Area Chart Basic 1
var series = {
	"monthDataSeries1": {
		"prices": [
			8,
			10,
			15,
			17,
			19,
			17,
			15,
			17,
			19,
			21,
			23,
			25,
			27,
			25,
			23,
			25,
			23,
			21,
			19,
			21,
			23,
			25,
			23,
			25,
			27,
			29,
			31,
			33,
			35,
			31,
			33,
			35,
			37,
			39,
			37,
			35,
			33,
			35,
			37,
			39,
			41,
			43,
			41,
			39,
			37,
			35,
			33,
			31,
			33,
			31,
			29,
			27,
			25,
			23,
			21,
			19,
			17,
			15,
			13,
			11
		],
		"dates": [
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
		]
	}
}

var options = {
	chart: {
		height: 280,
		type: 'area',
		toolbar: {
			show: false,
		},
		zoom: {
			enabled: false
		}
	},
	dataLabels: {
		enabled: false
	},
	grid: {
		show: false,
	},
	stroke: {
		curve: 'smooth',
		show: true,
		lineCap: 'butt',
		colors: undefined,
		width: 3,
		dashArray: 0, 
	},
	series: [{
		name: "Sales",
		data: series.monthDataSeries1.prices
	}],
	theme: {
		monochrome: {
			enabled: true,
			color: '#67caf0',
			shadeIntensity: 0.1
		},
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			opacityFrom: 0.7,
			opacityTo: 0.9,
			stops: [0, 90, 100]
		}
	},
	labels: series.monthDataSeries1.dates,
	xaxis: {
		show: false,
	},
	yaxis: {
		opposite: true,
		show: false,
	},
	legend: {
		horizontalAlign: 'left'
	}
}

var chart = new ApexCharts(
	document.querySelector("#apexAreaChartBasic"),
	options
);
chart.render();








































// Area Chart Basic 1
var series = {
	"monthDataSeries2": {
		"prices": [
			8,
			10,
			15,
			17,
			19,
			17,
			15,
			17,
			19,
			21,
			23,
			25,
			27,
			25,
			23,
			25,
			23,
			21,
			19,
			21,
			23,
			25,
			23,
			25,
			27,
			29,
			31,
			33,
			27,
			31,
			33,
			35,
			31,
			35,
			33,
			35,
			33,
			35,
			33,
			31,
			29,
			27,
			25,
			23,
			21,
			19,
			21,
			23,
			25,
			27,
			29,
			31,
			33,
			31,
			27,
			25,
			21,
			25,
			21,
		],
		"dates": [
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Jan",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Feb",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Mar",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"Apr",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"May",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
			"Jun",
		]
	}
}

var option2 = {
	chart: {
		height: 280,
		type: 'area',
		toolbar: {
			show: false,
		},
		zoom: {
			enabled: false
		}
	},
	dataLabels: {
		enabled: false
	},
	grid: {
		show: false,
	},
	stroke: {
		curve: 'smooth',
		show: true,
		lineCap: 'butt',
		colors: undefined,
		width: 3,
		dashArray: 0, 
	},
	series: [{
		name: "Expenses",
		data: series.monthDataSeries2.prices
	}],
	theme: {
		monochrome: {
			enabled: true,
			color: '#ff8087',
			shadeIntensity: 0.1
		},
	},
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			opacityFrom: 0.7,
			opacityTo: 0.9,
			stops: [0, 90, 100]
		}
	},
	labels: series.monthDataSeries2.dates,
	xaxis: {
		show: false,
		type: '',
	},
	yaxis: {
		opposite: true,
		show: false,
	},
	legend: {
		horizontalAlign: 'left'
	}
}

var chart = new ApexCharts(
	document.querySelector("#apexAreaChartBasic2"),
	option2
);
chart.render();



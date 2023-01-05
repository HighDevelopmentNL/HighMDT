// Apex Spine Gradient Example 1

var options = {
	chart: {
		height: 320,
		type: "area",
		toolbar: {
			show: false,
		},
	},
	dataLabels: {
		enabled: true,
	},
	stroke: {
		curve: 'smooth',
	},
	grid: {
		show: false,
	},
	series: [
		{
			name: "Visitors",
			data: [0, 20, 30, 20, 40, 20, 10]
		}
	],
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
	xaxis: {
		categories: [
			"Sun",
			"Mon",
			"Tue",
			"Wed",
			"Thu",
			"Fri",
			"Sat"
		]
	},
};

var chart = new ApexCharts(
	document.querySelector(
		"#apexSpineChartGradient"
	),
	options
);

chart.render();































// Apex Spine Gradient Example 2
var options2 = {
	chart: {
		height: 320,
		type: "area",
		toolbar: {
			show: false,
		},
	},
	dataLabels: {
		enabled: true,
	},
	stroke: {
		curve: 'straight',
	},
	grid: {
		show: false,
	},
	series: [
		{
			name: "Revenue",
			data: [0, 200, 300, 200, 100, 200, 100]
		}
	],
	theme: {
		monochrome: {
			enabled: true,
			color: '#a5ca7b',
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
	xaxis: {
		categories: [
			"Sun",
			"Mon",
			"Tue",
			"Wed",
			"Thu",
			"Fri",
			"Sat"
		]
	}
};

var chart = new ApexCharts(
	document.querySelector(
		"#apexSpineChartGradientGreen"
	),
	options2
);

chart.render();




// data: [150, 160, 170, 160, 167, 161, 161, 152, 140, 144, 154, 165, 175, 187, 197, 210, 196, 207, 200, 186, 192, 204, 192, 203, 208, 196, 192, 177, 190, 203, 218, 210, 217, 216, 201, 196, 190, 178, 171, 157, 158, 147, 151, 151, 143, 136, 135, 122, 112,]
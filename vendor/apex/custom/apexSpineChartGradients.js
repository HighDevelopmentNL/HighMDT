// Apex Spine Chart 1
var options = {
	chart: {
		height: 420,
		type: 'area',
		toolbar: {
			show: false,
			autoSelected: 'zoom' 
		},
	},
	dataLabels: {
		enabled: true
	},
	stroke: {
		curve: 'smooth'
	},
	grid: {
		show: false,
	},
	colors: ['#41ca94', '#67caf0'],
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.5,
			opacityTo: 0,
			stops: [0, 90, 100]
		}
	},
	series: [{
		name: 'Sales',
		data: [15, 30, 35, 45, 30, 25, 20]
	}, {
		name: 'Visitors',
		data: [10, 15, 20, 15, 20, 10, 15]
	}],
	legend: {
		show: true,
		position: 'bottom',
		horizontalAlign: 'center', 
		markers: {
			width: 10,
			height: 10,
			radius: 20,
		},
		itemMargin: {
			horizontal: 15,
			vertical: 10
		},
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
}

var chart = new ApexCharts(
	document.querySelector("#apexSpineChart"),
	options
);

chart.render();





































// Apex Spine Chart 2
var options2 = {
	chart: {
		height: 420,
		type: 'area',
		toolbar: {
			show: false,
			autoSelected: 'zoom' 
		},
	},
	dataLabels: {
		enabled: true
	},
	stroke: {
		curve: 'straight'
	},
	grid: {
		show: false,
	},
	colors: ['#ff8087', '#AC92EC'],
	fill: {
		type: 'gradient',
		gradient: {
			shadeIntensity: 1,
			inverseColors: false,
			opacityFrom: 0.5,
			opacityTo: 0,
			stops: [0, 90, 100]
		}
	},
	series: [{
		name: 'Income',
		data: [15, 30, 35, 45, 30, 25, 20]
	}, {
		name: 'Expenses',
		data: [10, 15, 20, 15, 20, 10, 15]
	}],
	legend: {
		show: true,
		position: 'bottom',
		horizontalAlign: 'center', 
		markers: {
			width: 10,
			height: 10,
			radius: 20,
		},
		itemMargin: {
			horizontal: 15,
			vertical: 10
		},
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
}

var chart = new ApexCharts(
	document.querySelector("#apexSpineChart2"),
	options2
);

chart.render();
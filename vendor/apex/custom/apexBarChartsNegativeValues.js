var options = {
  chart: {
    height: 270,
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false,
      autoSelected: 'zoom' 
    },
  },
  colors: ['#a5ca7b','#f38559'],
  plotOptions: {
    bar: {
      horizontal: true,
      barHeight: '40%',
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 1,
    colors: ["#ffffff"]
  },
  series: [{
    name: 'Visitors',
    data: [1, 2, 3, 4, 4.5, 5]
  },{
    name: 'Sales',
    data: [-1, -2, -3, -4, -4.5, -5]
  }],
  grid: {
    show: false,
    xaxis: {
      showLines: false
    }
  },
  yaxis: {
    min: -5,
    max: 5,
    title: {
      text: 'Age',
    },
  },
  tooltip: {
    shared: false,
    x: {
      formatter: function(val) {
        return val
      }
    },
    y: {
      formatter: function(val) {
        return Math.abs(val) + "%"
      }
    }
  },
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
    categories: ['60+', '50-59', '40-49', '30-39', '20-29', '15-19'],
    labels: {
      formatter: function(val) {
        return Math.abs(Math.round(val)) + "%"
      }
    }
  },
}

var chart = new ApexCharts(
  document.querySelector("#apexBarChartsNegativeValues"),
  options
);

chart.render();






























var options2 = {
  chart: {
    height: 270,
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false,
      autoSelected: 'zoom' 
    },
  },
  colors: ['#f9be52','#AC92EC'],
  plotOptions: {
    bar: {
      horizontal: true,
      barHeight: '40%',
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 1,
    colors: ["#ffffff"]
  },
  series: [{
    name: 'Income',
    data: [1, 2, 3, 4, 4.5, 5]
  },{
    name: 'Expenses',
    data: [-1, -2, -3, -4, -4.5, -5]
  }],
  grid: {
    show: false,
    xaxis: {
      showLines: false
    }
  },
  yaxis: {
    min: -5,
    max: 5,
    title: {
      text: 'Age',
    },
  },
  tooltip: {
    shared: false,
    x: {
      formatter: function(val) {
        return val
      }
    },
    y: {
      formatter: function(val) {
        return Math.abs(val) + "%"
      }
    }
  },
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
    categories: ['60+', '50-59', '40-49', '30-39', '20-29', '15-19'],
    labels: {
      formatter: function(val) {
        return Math.abs(Math.round(val)) + "%"
      }
    }
  },
}

var chart = new ApexCharts(
  document.querySelector("#apexBarChartsNegativeValues2"),
  options2
);

chart.render();



































var options3 = {
  chart: {
    height: 270,
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false,
      autoSelected: 'zoom' 
    },
  },
  colors: ['#67caf0','#ff8087'],
  plotOptions: {
    bar: {
      horizontal: true,
      barHeight: '40%',
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 1,
    colors: ["#ffffff"]
  },
  series: [{
    name: 'Male',
    data: [10, 20, 30, 40, 50, 60]
  },{
    name: 'Female',
    data: [-10, -20, -30, -40, -50, -60]
  }],
  grid: {
    show: false,
    xaxis: {
      showLines: false
    }
  },
  yaxis: {
    min: -60,
    max: 60,
    title: {
      text: 'Age',
    },
  },
  tooltip: {
    shared: false,
    x: {
      formatter: function(val) {
        return val
      }
    },
    y: {
      formatter: function(val) {
        return Math.abs(val) + "%"
      }
    }
  },
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
    categories: ['60+', '50-59', '40-49', '30-39', '20-29', '15-19'],
    labels: {
      formatter: function(val) {
        return Math.abs(Math.round(val)) + "%"
      }
    }
  },
}

var chart = new ApexCharts(
  document.querySelector("#apexBarChartsNegativeValues3"),
  options3
);

chart.render();
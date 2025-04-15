const xValues = [1,2,3,4,5,6,7,8,9,10,11];
const yValues = [7,8,8,9,9,9,10,11,14,14,15];

new Chart("stats", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.5)",
      data: yValues
    }]
  },
  options: {
    legend: { display: false},
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Days', // Customize this
          font: {
            size: 14,
            weight: 'bold'
          }
        }
      }],
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Ticket Quantity', // Customize this
          font: {
            size: 14,
            weight: 'bold'
          }
        },
        ticks: {
          min: 0,
          max: 16
        }
      }]
    }
  }
});
new Chart(
  document.getElementById('myChart'),
  {
    type: 'bar',
    data: {
      labels: timeReports.map(timeReport => timeReport.name).concat(Array.from({ length: Math.max(0, 6 - timeReports.length) }, () => '')),
      datasets: [{
        label: '1日/平均時間 TOP5',
        data: timeReports.map(timeReport => timeReport.avg_time).concat(Array.from({ length: Math.max(0, 6 - timeReports.length) }, () => 0)),
        backgroundColor: [
          '#FF000060',
          '#FF800060',
          '#FFCD5660',
          '#A9FF3C60',
          '#EEEAD860',
          '#D9D9D960'
        ],
        borderColor: [
          '#FF0000',
          '#FF8000',
          '#FFCD56',
          '#A9FF3C',
          '#EEEAD8',
          '#D9D9D9'
        ],
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      scales: {
        x: {
          suggestedMin: 0,
          suggestedMax: 10,
          ticks: {
            callback: function(value, _index, _ticks) {
              return value + 'h';
            },
            color: '#333'
          }
        },
        y: {
          ticks: {
            color: '#333'
          }
        }
      }
    }
  }
);
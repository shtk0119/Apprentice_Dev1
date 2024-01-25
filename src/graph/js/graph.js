new Chart(
  document.getElementById('myChart'),
  {
    type: 'bar',
    data: {
      labels: timeReports.map(timeReport => timeReport.name),
      datasets: [{
        label: '1日/平均時間',
        data: timeReports.map(timeReport => timeReport.avg_time),
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
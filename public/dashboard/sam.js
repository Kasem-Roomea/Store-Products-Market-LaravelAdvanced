let sam = {

    loadMultiLineChart(ctx, labels, datasets, title) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                /* elements: {
                    line: {
                        tension: 0.000001
                    }
                }, */
                responsive: true,
                title: {
                    display: true,
                    text: title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: title
                        }
                    }]
                }
            }
        })
    },

    loadLineChart(ctx, labels, data, datasets_label, title) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    fill: false,
                    label: datasets_label,
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: title
                        }
                    }]
                }
            }
        })
    },

    loadBarChart(ctx, labels, data, datasets_label, title) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    fill: false,
                    label: datasets_label,
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, .2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        barPercentage: 0.3,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: title
                        }
                    }]
                }
            }
        })
    },

    loadDoughnutChart(ctx, labels, data, datasets_label, bgColor, title) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels: labels,
                datasets: [{
                    label: datasets_label,
                    backgroundColor: bgColor,
                    data: data
                }]
            },
            options: {
                maintainAspectRatio: true,
                title: {
                    display: true,
                    text: title
                }
            }
        });
    },

    fillTheMissedMonthes(arr, addZero = false) {
        var newArr = arr;

        newArr = Array.from(Array(12).keys(), month => 
            newArr.find(value => +value.month === month+1) || { month: ("0"+(month+1)).substr(-2), value: 0 }
        );

        var res = [];
        
        if (addZero) {
            res.push(0);
        }

        newArr.forEach(element => {
            res.push(element.value);
        });

        return res;
    }

};

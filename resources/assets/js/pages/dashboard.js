'use strict';

let headingColor, labelColor, borderColor, legendColor;

if (isDarkStyle) {
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
} else {
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
}
// Color constant
const chartColors = {
    column: {
        series1: '#826af9',
        series2: '#d2b0ff',
        bg: '#f8d3ff'
    },
    donut: {
        series1: '#60beab',
        series2: '#677788',
        series3: '#f79292'
    },
    area: {
        series1: '#29dac7',
        series2: '#60f2ca',
        series3: '#a5f8cd'
    }
};

var options2 = {
    chart: {
        height: '250px',
        type: "radialBar",
    },
    series: [67],
    colors: ["#60beab"],
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 15,
                size: "60%"
            },
            startAngle: -135,
            endAngle: 135,
            track: {
                background: '#333',
                startAngle: -135,
                endAngle: 135,
            },
            dataLabels: {
                name: {
                    show: false,
                },
                value: {
                    fontSize: "30px",
                    show: true
                }
            }
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            type: "horizontal",
            gradientToColors: ["#f79292"],
            stops: [0, 100]
        }
    },
};


new ApexCharts(document.querySelector("#overall-score"), options2).render();
function renderDonutChart(selector, values) {

    let donutChartEl = document.querySelector('#'+selector);
    let donutChart = new ApexCharts(donutChartEl, {
        chart: {
            height: '250px',
            fontFamily: 'IBM Plex Sans',
            type: 'donut'
        },
        labels: Object.keys(values),
        series: Object.values(values),
        colors: [
            chartColors.donut.series1,
            chartColors.donut.series2,
            chartColors.donut.series3,
        ],
        stroke: {
            width: 4,
            height: 0.5,
            show: false,
            curve: 'straight'
        },
        legend: {
            position: 'bottom',
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '50%'
                },
            }
        }
    });
    donutChart.render();
}

function renderHorizontalChart(select, values, height = '400px') {
    let horizontalBarChartEl = document.querySelector('#'+select);
    const horizontalBarChart = new ApexCharts(horizontalBarChartEl, {
        chart: {
            height: height,
            width: '95%',
            fontFamily: 'IBM Plex Sans',
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                barHeight: '50%',
                horizontal: true,
                startingShape: 'rounded',
                borderRadius: 8
            }
        },
        grid: {
            borderColor: borderColor,
            xaxis: {
                lines: {
                    show: false
                }
            },
        },
        colors: [
            function({ value, seriesIndex, w }) {
                if (value > 75) {
                    return '#006400'
                } else if (value > 50) {
                    return '#e8e51c'
                } else {
                    return '#c92c14';
                }
            }
        ],
        dataLabels: {
            enabled: false
        },
        series: [
            {
                data: Object.values(values)
            }
        ],
        xaxis: {
            categories: Object.keys(values),
            axisBorder: {
                show: false
            },
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '13px'
                }
            },
            max: 100
        },
        yaxis: {
            labels: {
                maxWidth: 250,
                style: {
                    colors: labelColor,
                    fontSize: '13px',
                }
            }
        }
    });
    horizontalBarChart.render();
}

function initSchoolSelect(el)
{
    el.on('change', function() {
        console.log($(this).val());
        if ($(this).val() == "0") {
            window.location = window.location.href.split('?')[0];
        } else {
            window.location = '?school_id='+$(this).val();
        }
        return false;
    })
}

'use strict';

console.log("ok?")
let cardColor, headingColor, labelColor, borderColor, legendColor;

if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
} else {
    cardColor = config.colors.cardColor;
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
    },
    area: {
        series1: '#29dac7',
        series2: '#60f2ca',
        series3: '#a5f8cd'
    }
};
const donutChartEl = document.querySelector('#donutChart'),
    donutChartConfig = {
        chart: {
            height: 350,
            fontFamily: 'IBM Plex Sans',
            type: 'donut'
        },
        labels: ['Completed', 'Incomplete'],
        series: [75, 25],
        colors: [
            chartColors.donut.series1,
            chartColors.donut.series2,
        ],
        stroke: {
            show: false,
            curve: 'straight'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opt) {
                return parseInt(val) + '%';
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            labels: {
                colors: legendColor,
                useSeriesColors: false
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            fontSize: '2rem',
                            color: legendColor
                        },
                        value: {
                            fontSize: '1.2rem',
                            color: legendColor,
                            fontFamily: 'IBM Plex Sans',
                            formatter: function (val) {
                                return parseInt(val) + '%';
                            }
                        },
                        total: {
                            show: true,
                            fontSize: '1.5rem',
                            color: headingColor,
                            label: 'Surveys',
                            formatter: function (w) {
                                return '100';
                            }
                        }
                    }
                }
            }
        },
    };
console.log("beofre checking");
if (typeof donutChartEl !== undefined && donutChartEl !== null) {
    console.log("coming here");
    const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
    donutChart.render();
}
// Horizontal Bar Chart
// --------------------------------------------------------------------
const horizontalBarChartEl = document.querySelector('#horizontalBarChart'),
    horizontalBarChartConfig = {
        chart: {
            height: 300,
            fontFamily: 'IBM Plex Sans',
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '30%',
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
        colors: config.colors.primary,
        dataLabels: {
            enabled: false
        },
        series: [
            {
                data: [90, 80]
            }
        ],
        xaxis: {
            categories: ['design', 'sports'],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '13px'
                }
            }
        }
    };
if (typeof horizontalBarChartEl !== undefined && horizontalBarChartEl !== null) {
    console.log("should come to horizontal")
    const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
    horizontalBarChart.render();
}
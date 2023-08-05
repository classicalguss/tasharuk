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
$(function () {
    // Form sticky actions
    const stickyEl = $('.sticky-element');

    // sticky element init (Sticky Layout)
    if (stickyEl.length) {
        stickyEl.sticky({
            topSpacing: 0,
            zIndex: 9
        });
    }
});


function renderRadial(selector, value) {

    let color;
    if (value > 75) {
        color='#006400'
    } else if (value > 50) {
        color= '#e8e51c'
    } else {
        color= '#c92c14';
    }
    var radialOptions = {
        chart: {
            width: '100%',
            height: '350px',
            type: "radialBar",
        },
        series: [value],
        colors: [color],
        labels: ['Overall Score'],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 15,
                    size: "60%"
                },
                startAngle: -135,
                endAngle: 135,
                track: {
                    startAngle: -135,
                    endAngle: 135,
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        show: true,
                        color: '#888',
                        fontSize: '17px'
                    },
                    value: {
                        formatter: function(val) {
                            return val;
                        },
                        color: '#111',
                        fontSize: '36px',
                        show: true,
                    }
                }
            }
        },
    };
    new ApexCharts(document.querySelector('.'+selector), radialOptions).render();
}

function renderHorizontalChart(select, values, height = '400px') {
    let horizontalBarChartEl = document.querySelector('.'+select);
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
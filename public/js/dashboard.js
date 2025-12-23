$(document).ready(function () {
    "use strict";
    //labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    //value: [20, 30, 20, 40, 30, 60, 30, 24, 32, 38, 30, 22]

    //Income chart
    if ($('.invoice-chart-data').length && $('#invoice-chart').length) {
        var chart_invoice = JSON.parse($('.invoice-chart-data').val()),
        chart_bill = JSON.parse($('.bill-chart-data').val()),
        ctx = document.getElementById("invoice-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(chart_invoice.label),
                datasets: [{
                    label: "Invoice Revenue",
                    fill: true,
                    backgroundColor: '#3483FF',
                    borderColor: '#3483FF',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#3483FF",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_invoice.value),
                },{
                    label: "POS/Bill Revenue",
                    fill: true,
                    backgroundColor: '#A675D4',
                    borderColor: '#A675D4',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#A675D4",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                    data: JSON.parse(chart_bill.value),
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: true,
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month',
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4],
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10,
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value',
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4],
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10,
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2,
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12,
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0,
                },
                plugins: {
                    labels: []
                }
            }
        }); 
        //
    }

    //Expense chart
    if ($('.expense-chart-data').length && $('#expense-chart').length) {
        var chart_expense = JSON.parse($('.expense-chart-data').val()),
        ctx = document.getElementById("expense-chart").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#fd397a').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse(chart_expense.label),
                datasets: [{
                    label: "Expenses",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#fd397a',
                    // steppedLine: true,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#fd397a",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_expense.value)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    //Expense Type Chart
    if ($('.expense-type-chart-data').length && $('#expense-type-chart').length) {
        var chart_expense_type = JSON.parse($('.expense-type-chart-data').val()),
        ctx = document.getElementById("expense-type-chart").getContext("2d");
        new Chart(ctx, {
            type: 'pie',
            data: {
                fill: false,
                datasets: [{
                    data: JSON.parse(chart_expense_type.value),
                    backgroundColor: ['#0abb87', '#ffb822', '#fd397a', '#A675D4', '#cc5151', '#3483ff', '#5d78ff', '#132584', '#32C1CE', '#5E6EC7', '#54C798', '#EfA752', '#8895DC', '#282a3c', '#847533', '#555']
                }],
                labels: JSON.parse(chart_expense_type.label),
            },
            options: {
                cutoutPercentage: 40,
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        boxWidth: 10,
                        fontSize: 10
                    }
                },
                title: {
                    display: false,
                    text: 'Invoice Status Breakdown',
                    position: 'top',
                    fontFamily: 'Dosis',
                    fontSize: 16,
                    fontColor: '#333',
                    fontStyle: 'normal',
                    padding: 10
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'nearest',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: '#333',
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: [
                    //{render: 'label',position: 'outside',arc: true, fontColor: '#000', fontFamily: "'Poppins', sans-serif"},
                    {render: 'percentage', fontColor: "#fff", fontFamily: "'Poppins', sans-serif" }
                    ]
                }
            }
        });
    }

    //Purchase chart
    if ($('.purchase-chart-data').length && $('#purchase-chart').length) {
        var chart_purchase = JSON.parse($('.purchase-chart-data').val());
        ctx = document.getElementById("purchase-chart").getContext("2d");
        gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#ffb822').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse(chart_purchase.label),
                datasets: [{
                    label: "Purchase",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#ffb822',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#ffb822",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_purchase.value)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    //Salary chart
    if ($('.salary-chart-data').length && $('#salary-chart').length) {
        var chart_salary = JSON.parse($('.salary-chart-data').val()),
        ctx = document.getElementById("salary-chart").getContext("2d"),
        gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#03a9f3').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse(chart_salary.label),
                datasets: [{
                    label: "Salary",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#03a9f3',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#03a9f3",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_salary.value),
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    //Transaction chart
    if ($('.transaction-chart-data').length && $('#transaction-chart').length) {
        var chart_transaction = JSON.parse($('.transaction-chart-data').val()),
        ctx = document.getElementById("transaction-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(chart_transaction.label),
                datasets: [{
                    label: "Credit",
                    fill: true,
                    backgroundColor: '#3483FF',
                    borderColor: '#3483FF',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#3483FF",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_transaction.credit),
                },{
                    label: "Debit",
                    fill: true,
                    backgroundColor: '#fd397a',
                    borderColor: '#fd397a',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#fd397a",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_transaction.debit)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    //Customer chart
    if ($('.customer-chart-data').length && $('#customer-chart').length) {
        var chart_customer = JSON.parse($('.customer-chart-data').val()),
        ctx = document.getElementById("customer-chart").getContext("2d"),
        gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#0abb87').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse(chart_customer.label),
                datasets: [{
                    label: "Customer",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#0abb87',
                    steppedLine: true,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#0abb87",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(chart_customer.value),
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                }
            }
        });
        //
    }

    //Report Bill chart
    if ($('.report-bill-chart-data').length && $('#report-bill-chart').length) {
        var report_bill_chart = JSON.parse($('.report-bill-chart-data').val()),
        ctx = document.getElementById("report-bill-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(report_bill_chart.label),
                datasets: [{
                    label: "Amount",
                    fill: true,
                    backgroundColor: '#3483FF',
                    borderColor: '#3483FF',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#3483FF",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(report_bill_chart.value),
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    //Report Expense chart
    if ($('.report-expense-chart-data').length && $('#report-expense-chart').length) {
        var report_expense_chart = JSON.parse($('.report-expense-chart-data').val()),
        ctx = document.getElementById("report-expense-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(report_expense_chart.label),
                datasets: [{
                    label: "Amount",
                    fill: true,
                    backgroundColor: '#FD397A',
                    borderColor: '#FD397A',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#FD397A",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(report_expense_chart.value),
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    if ($('.report-invoice-chart-data').length && $('#report-invoice-chart').length) {
        var report_invoice_chart = JSON.parse($('.report-invoice-chart-data').val()),
        ctx = document.getElementById("report-invoice-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(report_invoice_chart.label),
                datasets: [{
                    label: "Amount",
                    fill: true,
                    backgroundColor: '#3483FF',
                    borderColor: '#3483FF',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#3483FF",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(report_invoice_chart.value)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });
        //
    }

    if ($('.report-invoice-status-chart-data').length && $('#report-invoice-status-chart').length) {
        var report_invoice_status_chart = JSON.parse($('.report-invoice-status-chart-data').val()),
        ctx = document.getElementById("report-invoice-status-chart").getContext("2d");
        new Chart(ctx, {
            type: 'pie',
            data: {
                fill: false,
                datasets: [{
                    data: JSON.parse(report_invoice_status_chart.value),
                    backgroundColor: ['#0abb87', '#ffb822', '#fd397a', '#A675D4', '#cc5151', '#3483ff']
                }],
                labels: JSON.parse(report_invoice_status_chart.label)
            },
            options: {
                cutoutPercentage: 30,
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: true,
                    position: 'left',
                    labels: {
                        boxWidth: 10,
                        fontSize: 10
                    }
                },
                title: {
                    display: false,
                    text: 'Invoice Status Breakdown',
                    position: 'top',
                    fontFamily: 'Dosis',
                    fontSize: 16,
                    fontColor: '#333',
                    fontStyle: 'normal',
                    padding: 10
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'nearest',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: '#333',
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: [
                    //{render: 'label',position: 'outside',arc: true, fontColor: '#000', fontFamily: "'Poppins', sans-serif"},
                    {render: 'percentage', fontColor: "#fff", fontFamily: "'Poppins', sans-serif" }
                    ]
                }
            }
        });
        //
    }

    if ($('.report-purchase-chart-data').length && $('#report-purchase-chart').length) {
        var report_purchase_chart = JSON.parse($('.report-purchase-chart-data').val()),
        ctx = document.getElementById("report-purchase-chart").getContext("2d");
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse(report_purchase_chart.label),
                datasets: [{
                    label: "Amount",
                    fill: true,
                    backgroundColor: '#5d78ff',
                    borderColor: '#5d78ff',
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                    pointHoverBackgroundColor: "#5d78ff",
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),
                    data: JSON.parse(report_purchase_chart.value)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        categoryPercentage: 0.45,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }],
                    yAxes: [{
                        categoryPercentage: 0.35,
                        barPercentage: 0.70,
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        },
                        gridLines: {
                            color: "#d9dffa",
                            drawBorder: false,
                            offsetGridLines: false,
                            drawTicks: false,
                            borderDash: [3, 4],
                            zeroLineWidth: 1,
                            zeroLineColor: "#d9dffa",
                            zeroLineBorderDash: [3, 4]
                        },
                        ticks: {           
                            display: true,
                            beginAtZero: true,
                            fontColor: "#afb4d4",
                            fontSize: 13,
                            padding: 10
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.2
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'index',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10, 
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: "#333333",
                    titleFontColor: '#ffffff', 
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                },
                plugins: {
                    labels: []
                }
            }
        });

        //
    }
});









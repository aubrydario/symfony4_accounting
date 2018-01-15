import Chart from 'chart.js';
import moment from 'moment';

moment.locale('de-ch');

let billsAmountPerMonth = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
let paymentsAmountPerMonth = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

function getBills() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/bills",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

function getPayments() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/payments",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

/*
    GET LABELS FOR THE LAST SIX MONTHS

function getLables() {
    const today = new Date();
    let d;
    let months = [];

    for(let i = 6; i >= 0; i -= 1) {
        d = new Date(today.getFullYear(), today.getMonth() - i, 1);
        months.push(moment().month(d.getMonth()).format('MMMM'));
    }

    return months;
}
*/

// Trigger when both Ajax requests are done
$.when(getBills(), getPayments()).done((bills, payments) => {
    bills[0].forEach(b => {
        billsAmountPerMonth[parseInt(moment(b.date.date).format('M')) - 1] += b.amount;
    });

    payments[0].forEach(p => {
        paymentsAmountPerMonth[parseInt(moment(p.date.date).format('M')) - 1] += p.amount;
    });

    billsAndPaymentsChart.update();
});

const billsAndPaymentsChartCtx = document.getElementById('billsAndPaymentsChart').getContext('2d');
const billsAndPaymentsChart = new Chart(billsAndPaymentsChartCtx, {
    type: 'line',
    data: {
        labels: moment.months(),
        datasets: [
            {
                label: 'Einnahmen in Fr.',
                backgroundColor: 'rgba(36, 147, 11, 0.2)',
                borderColor: 'rgba(36, 147, 11, 1)',
                data: billsAmountPerMonth
            },
            {
                label: 'Ausgaben in Fr.',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                borderColor: 'rgba(255, 0, 0, 1)',
                data: paymentsAmountPerMonth
            }
        ]
    },
    options: {
        responsive: true,
        title:{
            display:true,
            text:'Einnahmen und Ausgaben'
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
                    labelString: 'Monat'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Wert (Fr.)'
                },
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
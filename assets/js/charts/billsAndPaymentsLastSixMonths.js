import Chart from 'chart.js';
import moment from 'moment';

export default function getBillsAndPaymentsLastSixMonthsChart() {
    moment.locale('de-ch');

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

    let monthCount = 6;
    let billsAmountPerMonth = [];
    let paymentsAmountPerMonth = [];

    for(let i = 0 ; i < monthCount ; i++) {
        billsAmountPerMonth.push(0);
        paymentsAmountPerMonth.push(0);
    }

//GET LABELS FOR THE LAST SIX MONTHS
    function getLables() {
        const today = new Date();
        let d;
        let months = [];

        for(let i = monthCount - 1 ; i >= 0; i -= 1) {
            d = new Date(today.getFullYear(), today.getMonth() - i, 1);
            months.push(moment().month(d.getMonth()).format('MMMM'));
        }

        return months;
    }

// Trigger when both Ajax requests are done
    $.when(getBills(), getPayments()).done((bills, payments) => {

        const today = new Date();
        let monthBefore = new Date(today.getFullYear(), today.getMonth() - monthCount, 1).getMonth();

        bills[0].forEach(b => {
            if(parseInt(moment(b.date.date).format('M')) - 1 <= today.getMonth() || parseInt(moment(b.date.date).format('M')) - 1 > monthBefore) {
                if(parseInt(moment(b.date.date).format('M')) - monthCount - 2 < 0) {
                    let diff = parseInt(moment(b.date.date).format('M')) - monthCount - 2;
                    billsAmountPerMonth[12 + diff] += b.amount;
                } else {
                    billsAmountPerMonth[parseInt(moment(b.date.date).format('M')) - monthCount - 2] += b.amount;
                }
            }
        });

        payments[0].forEach(p => {
            if(parseInt(moment(p.date.date).format('M')) - 1 <= today.getMonth() || parseInt(moment(p.date.date).format('M')) - 1 > monthBefore) {
                if(parseInt(moment(p.date.date).format('M')) - monthCount - 2 < 0) {
                    let diff = parseInt(moment(p.date.date).format('M')) - monthCount - 2;
                    paymentsAmountPerMonth[12 + diff] += p.amount;
                } else {
                    paymentsAmountPerMonth[parseInt(moment(p.date.date).format('M')) - monthCount - 2] += p.amount;
                }
            }
        });

        billsAndPaymentsChart.update();
    });

    const billsAndPaymentsChartCtx = document.getElementById('billsAndPaymentsChart').getContext('2d');
    const billsAndPaymentsChart = new Chart(billsAndPaymentsChartCtx, {
        type: 'line',
        data: {
            labels: getLables(),
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
                text:'Einnahmen und Ausgaben für die letzten 6 Monate'
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
}
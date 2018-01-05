import Chart from 'chart.js';

let sumedUpDates = [];
let prices = [];
/*
const request = new XMLHttpRequest();
request.open('GET', 'http://localhost:3000/accounting/transactions.json');
request.responseType = 'json';
request.send();
request.onload = function() {
    const transactions = request.response.transactions;

    // sort array by date
    transactions.sort((a, b) => {
        let c = new Date(a.date);
        let d = new Date(b.date);
        return c-d;
    });

    function isDateSumedUp(date) {
        return sumedUpDates.indexOf(date.substring(0, 7)) !== -1;
    }

    function sumUpDate(date) {
        let sum = 0;

        transactions.forEach(t => {
            if(t.date.substring(0, 7) === date.substring(0, 7)) {
                sum += parseInt(t.aboPrice);
            }
        });

        sumedUpDates.push(date.substring(0, 7));
        prices.push(sum);
    }

    transactions.forEach(t => {
        if(!isDateSumedUp(t.date)) {
            sumUpDate(t.date);
        }
    });

    chart.update();
};

const ctx = document.getElementById('chart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: sumedUpDates,
        datasets: [{
            label: 'Einnahmen in Fr.',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            data: prices
        }]
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
*/
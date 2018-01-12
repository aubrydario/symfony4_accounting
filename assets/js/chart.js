import Chart from 'chart.js';
import moment from 'moment';

moment.locale('de-ch');

let sumedUpDates = [];
let prices = [];

const request = new XMLHttpRequest();
request.open('GET', 'http://localhost:8000/api/transactions');
request.responseType = 'json';
request.send();
request.onload = function() {
    const transactions = request.response;

    // sort array by date
    transactions.sort((a, b) => {
        let c = new Date(a.date.date);
        let d = new Date(b.date.date);
        return c-d;
    });

    function isDateSumedUp(date) {
        return sumedUpDates.indexOf(moment(date).format('MMMM YY')) !== -1;
    }

    function sumUpDate(date) {
        let sum = 0;

        transactions.forEach(t => {
            if(moment(t.date.date).format('MMMM YY') === moment(date).format('MMMM YY')) {
                sum += parseInt(t.price);
            }
        });

        sumedUpDates.push(moment(date).format('MMMM YY'));
        prices.push(sum);
    }

    transactions.forEach(t => {
        if(!isDateSumedUp(t.date.date)) {
            sumUpDate(t.date.date);
        }
    });

    chart.update();
};

const ctx = document.getElementById('chart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: sumedUpDates,
        datasets: [
            {
                label: 'Einnahmen in Fr.',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: prices
            },
            {
                label: 'Ausgaben in Fr.',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                borderColor: 'rgba(255, 0, 0, 1)',
                data: [
                    234, 500, 134, 50
                ]
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
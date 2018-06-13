import Chart from 'chart.js';
import moment from 'moment';
import ajax from '../components/ajaxCall';

export default function getBillsAndPaymentsLastSixMonthsChart() {
    moment.locale('de-ch');
    let billsAndPaymentsChart;

    const monthCount = 6;

    //Crate labels array for the last six months
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
    $.when(ajax('GET', '/api/bills'), ajax('GET', '/api/payments')).done((bills, payments) => {
console.log(bills);
        // Remove Spinner
        document.getElementsByClassName('spinner')[0].style.display = 'none';

        const billsAndPaymentsChartCtx = document.getElementById('billsAndPaymentsChart').getContext('2d');
        billsAndPaymentsChart = new Chart(billsAndPaymentsChartCtx, {
            type: 'line',
            data: {
                labels: getLables(),
                datasets: [
                    {
                        label: 'Einnahmen in Fr.',
                        backgroundColor: 'rgba(36, 147, 11, 0.2)',
                        borderColor: 'rgba(36, 147, 11, 1)',
                        data: getAmountPerMonth(bills[0])
                    },
                    {
                        label: 'Ausgaben in Fr.',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        borderColor: 'rgba(255, 0, 0, 1)',
                        data: getAmountPerMonth(payments[0])
                    }
                ]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Einnahmen und Ausgaben der letzten 6 Monate'
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
    });

    function getAmountPerMonth(dataArray) {
        let resultArray = [];
        for(let i = 0 ; i < monthCount ; i++) {
            resultArray.push(0);
        }

        const thisMonth = parseInt(moment().format('M'));
        const monthBefore = parseInt(moment().subtract(monthCount, 'months').format('M')) + 1;

        dataArray.forEach(item => {
            const itemMonth = parseInt(moment(item.date.date).format('M'));

            if(itemMonth <= thisMonth || itemMonth >= monthBefore) {
                let index;
                if(itemMonth - monthBefore < 0) {
                    index = itemMonth + 12 - monthBefore;
                } else {
                    index = itemMonth - monthBefore;
                }
                resultArray[index] += item.amount;
            }
        });

        return resultArray;
    }
}
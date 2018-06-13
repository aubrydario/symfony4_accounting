import Chart from 'chart.js';
import ajax from '../components/ajaxCall';

export default function getCustomersChart() {
    let customersChart;

    const customers =  ajax('GET', '/api/customers', { complete: () => {
        console.log(customers);

        // Remove Spinner
        document.getElementsByClassName('spinner')[1].style.display = 'none';

        const customersChartCtx = document.getElementById('customersChart').getContext('2d');
        customersChart = new Chart(customersChartCtx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        customers.responseJSON[0] ? customers.responseJSON[0].genderCount : 0,
                        customers.responseJSON[1] ? customers.responseJSON[1].genderCount : 0
                    ],
                    backgroundColor: [
                        'rgba(36, 147, 11, 0.8)',
                        'rgba(255, 0, 0, 0.8)'
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Frauen',
                    'Herren'
                ]
            },
            options: {
                responsive: true
            }
        });
    }});
}
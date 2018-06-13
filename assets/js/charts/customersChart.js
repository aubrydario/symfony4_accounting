import Chart from 'chart.js';
import ajax from '../components/ajaxCall';

export default function getCustomersChart() {
    let customersChart;

    let customers =  ajax('GET', '/api/customers?active=1', { complete: () => {
        customers = customers.responseJSON;
        let men = [];
        let women = [];

        customers.forEach(customer => {
            if(customer.gender === "Herr") {
                men.push(customer);
            } else {
                women.push(customer);
            }
        });

        console.log(customers);

        // Remove Spinner
        document.getElementsByClassName('spinner')[1].style.display = 'none';

        const customersChartCtx = document.getElementById('customersChart').getContext('2d');
        customersChart = new Chart(customersChartCtx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        women.length,
                        men.length
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
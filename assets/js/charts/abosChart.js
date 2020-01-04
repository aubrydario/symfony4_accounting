import Chart from 'chart.js';
import ajax from '../components/ajaxCall';

export default function getAbosChart(user) {
    let abosChart;

    let abos = ajax('GET', `/api/users/${user.id}/billsAndAbos`, { complete: () => {
        abos = abos.responseJSON;
        let labels = [], amounts = [], colors = [];

        abos.forEach(abo => {
            labels.push(abo.name);
            amounts.push(abo.amount);
            colors. push(abo.color);
        });

        // Remove Spinner
        document.getElementsByClassName('spinner')[1].style.display = 'none';

        const abosChartCtx = document.getElementById('abosChart').getContext('2d');
        abosChart = new Chart(abosChartCtx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: amounts,
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
                labels: labels
            },
            options: {
                responsive: true
            }
        });
    }});
}

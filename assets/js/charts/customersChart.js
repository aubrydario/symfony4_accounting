import Chart from 'chart.js';
import moment from 'moment';

export default function getCustomersChart() {
    let customersChart;

    const customers =  $.ajax({
        type: "GET",
        dataType: 'json',
        url: "/api/customers",
        async: true,
        contentType: "application/json; charset=utf-8",
        complete: () => {
            // Remove Spinner
            document.getElementsByClassName('spinner')[1].style.display = 'none';

            const customersChartCtx = document.getElementById('customersChart').getContext('2d');
            customersChart = new Chart(customersChartCtx, {
                type: 'pie',
                data: {
                    datasets: [
                        {
                            data: [customers.responseJSON[0].genderCount, customers.responseJSON[1].genderCount],
                        }
                    ],
                    lables: ['Frauen', 'Herren']
                }
            });
        }
    });
}
import billsAndPaymentsChart from './charts/billsAndPayments';
import customersChart from './charts/customersChart';
import abosChart from './charts/abosChart';
import ajax from "./components/ajaxCall";

let user = ajax('GET', '/api/activeUser', {complete: function() {
    user = user.responseJSON[0];

    billsAndPaymentsChart(user);
    //customersChart(user);
    abosChart(user);
}});

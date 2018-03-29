import moment from 'moment';
import d3 from 'd3';
import ajax from './components/ajaxCall';

moment.locale('de-ch');

// Trigger when all Ajax requests are done
$.when(ajax('GET', '/api/attendance'), ajax('GET', '/api/attendanceDetails'), ajax('GET', '/api/hour')).done((bills, attendances, hours) => {
    // Remove Spinner
    document.getElementsByClassName('spinner')[0].style.display = 'none';

    createTable(bills[0], attendances[0], hours[0]);
});

const table = d3.select('#attendance-table').append('table').attr('class', 'table table-bordered');
const thead = table.append('thead');
const tbody = table.append('tbody');

function createTable(data, attendances, hours) {
    const dateRow = thead.append('tr');
    const timeRow = thead.append('tr');
    let week = 0;

    dateRow.append('th');
    timeRow.append('th');

    for(let i = 0; i < 52; i++) {
        hours.forEach(hour => {
            let hourTimeArray = hour.time ? hour.time.split(',') : [];
            let hourIdArray = hour.id ? hour.id.split(',') : [];
            let addDays = hour.day - 1 + week;

            dateRow.append('th')
                .text(moment().startOf('week').add(addDays, 'days').format('dd D.M.YY'))
                .attr('colspan', hourTimeArray.length);

            hourTimeArray.forEach((time, index) => {
                timeRow.append('th')
                    .text(moment(time, 'HH:mm:ss').format('HH:mm'))
                    .attr('data-date', moment().startOf('week').add(addDays, 'days').format('dd D.M.YY'))
                    .attr('data-id', hourIdArray[index]);
            });
        });
        week += 7;
    }

    // create a row for each object in the data
    tbody.selectAll('tr')
        .data(data)
        .enter()
        .append('tr');

    data.forEach((item, index1) => {
        const row = tbody.select(`tr:nth-child(${++index1})`);
        let itemDateArray = item.date ? item.date.split(',') : [];
        let itemEnddateArray = item.enddate ? item.enddate.split(',') : [];
        let aboIdArray = item.abo_id ? item.abo_id.split(',') : [];
        let billIdArray = item.bill_id ? item.bill_id.split(',') : [];

        row.append('td')
            .text(item.name);

        let size = timeRow.selectAll('th').size() - 1;

        for(let i = 1; i <= size; i++) {
            let theadDate = moment(timeRow.selectAll('th')[0][i].dataset.date, 'D.M.YY').format('YYYY-MM-DD');
            let theadTime = moment(timeRow.selectAll('th')[0][i].innerText, 'HH:mm').format('HH:mm:ss');

            row.append('td');

            itemDateArray.forEach((date, index) => {
                let itemDate = moment(date).format('YYYY-MM-DD');
                let field = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`);

                switch(aboIdArray[index]) {
                    //Einzelstunde
                    case '1':
                        if (itemDate <= theadDate && itemEnddateArray[index] >= theadDate) {
                            field.attr('class', 'abo einzelstunde')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //Schnupperstunde
                    case '2':
                        if (itemDate <= theadDate && itemEnddateArray[index] >= theadDate) {
                            field.attr('class', 'abo schnupperstunde')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //10er-Abo
                    case '3':
                        if (itemDate <= theadDate && itemEnddateArray[index] >= theadDate) {
                            field.attr('class', 'abo zehnerabo')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //Jahresabo
                    case '4':
                        if (itemDate <= theadDate && itemEnddateArray[index] >= theadDate) {
                            field.attr('class', 'abo jahresabo')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;
                }
            });

            attendances.forEach(attendance => {
                let currentField = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`)[0][0];

                if(moment(attendance.date).format('YYYY-MM-DD') === theadDate
                    && attendance.time === theadTime
                    && attendance.billId === currentField.dataset.billid) {
                        let icon = currentField.appendChild(document.createElement('i'));
                        icon.classList.add('fa');
                        icon.classList.add('fa-check');
                        icon.dataset.id = attendance.id;
                }
            });
        }
    });
}

function showInfo(timeRow) {
    let element = d3.event.target;

    // If the icon is clicked get the parent td element
    if(element.nodeName !== 'TD') {
        element = element.parentElement;
    }

    if(!element.hasChildNodes()) {
        const data = ajax('GET', '/api/attendanceCount/' + d3.event.target.dataset.billid, {complete: () => {
            let attendanceCount = JSON.parse(data.responseText)[0];

            if(!attendanceCount || parseInt(attendanceCount.attendanceCount) < parseInt(attendanceCount.maxVisits)) {
                let icon = element.appendChild(document.createElement('i'));
                icon.classList.add('fa');
                icon.classList.add('fa-check');

                let response = {
                    'date': moment(timeRow.select(`th:nth-child(${element.cellIndex + 1})`)[0][0].dataset.date, 'D.M.YY').format('YYYY-MM-DD'),
                    'bill_id': element.dataset.billid,
                    'hour_id': timeRow.select(`th:nth-child(${element.cellIndex + 1})`)[0][0].dataset.id
                };

                const postAttendance = ajax('POST', '/api/attendanceDetails', {
                        data: JSON.stringify(response),
                        complete: () => { icon.dataset.id = postAttendance.responseText; }
                    }
                );

            } else {
                alert('Max erreicht');
            }
        }});
    } else {
        let icon = element.getElementsByTagName('i')[0];
        let id = icon.dataset.id;
        icon.remove();

        ajax('DELETE', '/api/attendanceDetails', { data: JSON.stringify({id: id}) });
    }
}

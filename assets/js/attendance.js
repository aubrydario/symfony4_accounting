import moment from 'moment';
import d3 from 'd3';

moment.locale('de');

function getBills() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/attendance",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

function getHour() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/hour",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

function getAttendance() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/attendanceDetails",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

// Trigger when both Ajax requests are done
$.when(getBills(), getAttendance(), getHour()).done((bills, attendances, hours) => {
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

    for(let i = 0; i < 4; i++) {
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
                        if (itemDate === theadDate) {
                            field.attr('class', 'einzelstunde')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //Schnupperstunde
                    case '2':
                        if (itemDate === theadDate) {
                            field.attr('class', 'schnupperstunde')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //10er-Abo
                    case '3':
                        if (itemDate <= theadDate && moment(itemDate).add(12, 'weeks').format('YYYY-MM-DD') >= theadDate) {
                            field.attr('class', 'zehnerabo')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(timeRow); });
                        }
                        break;

                    //Jahresabo
                    case '4':
                        if (itemDate <= theadDate && moment(itemDate).add(1, 'year').format('YYYY-MM-DD') >= theadDate) {
                            field.attr('class', 'jahresabo')
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
                    && attendance.id === currentField.dataset.billid) {
                        let icon = currentField.appendChild(document.createElement('i'));
                        icon.classList.add('fa');
                        icon.classList.add('fa-check');
                }
            });
        }
    });
}

function showInfo(timeRow) {
    const element = d3.event.target;
    const data = $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/attendanceCount/" + d3.event.target.dataset.billid,
        async: true,
        contentType: "application/json; charset=utf-8"
    }).done(() => {
        const attendanceCount = JSON.parse(data.responseText)[0];

        attendanceCount.maxVisits = !attendanceCount.maxVisits ? '10000' : attendanceCount.maxVisits;

        if(!attendanceCount) {
            postAttendance(element, timeRow);
        } else if(parseInt(attendanceCount.attendanceCount) < parseInt(attendanceCount.maxVisits)) {
            postAttendance(element, timeRow);
        } else {
            alert('Max erreicht');
        }
    });
}

function postAttendance(element, timeRow) {
    if(!element.hasChildNodes()) {
        let icon = element.appendChild(document.createElement('i'));
        icon.classList.add('fa');
        icon.classList.add('fa-check');

        let response = {
            date: moment(timeRow.select(`th:nth-child(${element.cellIndex + 1})`)[0][0].dataset.date, 'D.M.YY').format('YYYY-MM-DD'),
            bill_id: element.dataset.billid,
            hour_id: timeRow.select(`th:nth-child(${element.cellIndex + 1})`)[0][0].dataset.id
        };

        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/api/attendanceDetails',
            data: JSON.stringify(response),
            dataType: 'application/json; charset=utf-8'
        });
    }
}

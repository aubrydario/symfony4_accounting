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
    // append the header row
    const dateRow = thead.append('tr');
    dateRow.append('th');

    const timeRow = thead.append('tr');
    timeRow.append('th');

    //if(moment().startOf('week').isoWeekday(hour.day).format('E') === hour.day) {
    let week = 0;
    for(let i = 0; i < 4; i++) {
        hours.forEach(hour => {
            let hourTimeArray = hour.time ? hour.time.split(',') : [];
            let addDays = hour.day - 1 + week;

            dateRow.append('th')
                .text(moment().startOf('week').add(addDays, 'days').format('dd D.M.YY'))
                .attr('colspan', hourTimeArray.length);

            hourTimeArray.forEach(time => {
                timeRow.append('th')
                    .text(moment(time, 'HH:mm:ss').format('HH:mm'))
                    .attr('data-date', moment().startOf('week').add(addDays, 'days').format('dd D.M.YY'));
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

            row.append('td');

            attendances.forEach(attendance => {
                let currentField = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`)[0][0];

                if(moment(attendance.date).format('YYYY-MM-DD') === theadDate && currentField.parentNode.firstChild.innerHTML === attendance.name) {
                    let icon = currentField.appendChild(document.createElement('i'));
                    icon.classList.add('fa');
                    icon.classList.add('fa-check');
                }
            });

            itemDateArray.forEach((date, index) => {
                let itemDate = moment(date).format('YYYY-MM-DD');

                switch(aboIdArray[index]) {
                    //Einzelstunde
                    case '1':
                        if (itemDate === theadDate) {
                            let field = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`)
                                .attr('class', 'einzelstunde')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(theadDate); });
                        }
                        break;

                    //Schnupperstunde
                    case '2':
                        //console.log('Schnupperstunde');
                        break;

                    //10er-Abo
                    case '3':
                        if (itemDate <= theadDate && moment(itemDate).add(12, 'weeks').format('YYYY-MM-DD') >= theadDate) {
                            let field = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`)
                                .attr('class', 'zehnerabo')
                                .attr('data-billId', billIdArray[index]);

                            field.on('click', () => { showInfo(theadDate); });
                        }
                        break;

                    //Jahresabo
                    case '4':
                        //console.log('Jahresabo');
                        break;
                }
            });
        }
    });
}

function showInfo(date) {
    if(!d3.event.target.hasChildNodes()) {
        let icon = d3.event.target.appendChild(document.createElement('i'));
        icon.classList.add('fa');
        icon.classList.add('fa-check');

        let response = {
            date: date,
            bill_id: d3.event.target.dataset.billid
        };
        console.log(response);

        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/api/attendanceDetails',
            data: JSON.stringify(response),
            success: () => { console.log('success'); },
            dataType: 'application/json; charset=utf-8'
        });
    }
}

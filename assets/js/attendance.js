import moment from 'moment';
import d3 from 'd3';
import ajax from './components/ajaxCall';
import daterangepicker from 'daterangepicker';
import colorpicker from 'spectrum-colorpicker';

moment.locale('de-ch');

let activeUser = ajax('GET', '/api/activeUser', { complete: () => {
    activeUser = activeUser.responseJSON;

    let dataColorpicker = ajax('GET', `/api/users/${activeUser[0].id}/abos`, { complete: () => {
        dataColorpicker = dataColorpicker.responseJSON;
        setupColorpicker(dataColorpicker);
    }});
}});

loadData();

function loadData(start = moment().subtract(14, 'days'), end = moment().add(14, 'days')) {
    // Trigger when all Ajax requests are done
    $.when(ajax('GET', '/api/attendance'), ajax('GET', '/api/attendanceDetails'), ajax('GET', '/api/hour')).done((bills, attendances, hours) => {
        // Remove Spinner
        document.getElementsByClassName('spinner')[0].style.display = 'none';

        $('#daterangepicker').daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: {
                'Letzten 30 Tage': [moment().subtract(29, 'days'), moment()],
                'Dieser Monat': [moment().startOf('month'), moment().endOf('month')],
                'Letzter Monat': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                cancelLabel: 'Abbrechen',
                applyLabel: 'Speichern',
                customRangeLabel: 'Selber Auswählen'
            }
        }, (start, end) => {
            document.getElementsByClassName('table-bordered')[0].remove();
            loadData(start, end);
        });

        document.querySelector('#daterangepicker span').innerHTML = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY');

        createTable(start, end, bills[0], attendances[0], hours[0]);
    });
}

function createTable(startDate, endDate, data, attendances, hours) {
    const table = d3.select('#attendance-table').append('table').attr('class', 'table table-bordered');
    const thead = table.append('thead');
    const tbody = table.append('tbody');
    const dateRow = thead.append('tr');
    const timeRow = thead.append('tr');
    const weekCount = endDate.diff(startDate, 'weeks');
    let week = 0;

    dateRow.append('th');
    timeRow.append('th');

    for(let i = 0; i <= weekCount; i++) {
        hours.forEach(hour => {
            let hourTimeArray = hour.time ? hour.time.split(',') : [];
            let hourIdArray = hour.id ? hour.id.split(',') : [];
            let addDays = hour.day - 1 + week;

            dateRow.append('th')
                .text(startDate.startOf('week').add(addDays, 'days').format('dd D.M.YY'))
                .attr('colspan', hourTimeArray.length);

            hourTimeArray.forEach((time, index) => {
                timeRow.append('th')
                    .text(moment(time, 'HH:mm:ss').format('HH:mm'))
                    .attr('data-date', startDate.startOf('week').add(addDays, 'days').format('dd D.M.YY'))
                    .attr('data-id', hourIdArray[index]);
            });
        });
        startDate.add(1, 'week')
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
        let aboNameArray = item.abo_name ? item.abo_name.split(',') : [];
        let billIdArray = item.bill_id ? item.bill_id.split(',') : [];

        row.append('td')
            .text(item.c_name);

        let size = timeRow.selectAll('th').size() - 1;

        for(let i = 1; i <= size; i++) {
            let theadDate = moment(timeRow.selectAll('th')[0][i].dataset.date, 'D.M.YY').format('YYYY-MM-DD');
            let theadTime = moment(timeRow.selectAll('th')[0][i].innerText, 'HH:mm').format('HH:mm:ss');

            row.append('td');

            itemDateArray.forEach((date, index) => {
                let itemDate = moment(date).format('YYYY-MM-DD');
                let field = row.select(`td:nth-child(${timeRow.selectAll('th')[0][i].cellIndex + 1})`);

                if (itemDate <= theadDate && itemEnddateArray[index] >= theadDate) {
                    field.attr('class', `abo ${aboNameArray[index]}`)
                        .attr('data-billId', billIdArray[index]);

                    field.on('click', () => { showInfo(timeRow); });
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
                    'bill': '/api/bills/' + element.dataset.billid,
                    'hour': '/api/hours/' + timeRow.select(`th:nth-child(${element.cellIndex + 1})`)[0][0].dataset.id
                };

                const postAttendance = ajax('POST', '/api/attendances', {
                        data: JSON.stringify(response),
                        complete: () => {icon.dataset.id = JSON.parse(postAttendance.responseText).id; }
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

        ajax('DELETE', `/api/attendances/${id}`);
    }
}

function setupColorpicker(data) {
    data.forEach(item => {
        document.styleSheets[0].insertRule(`.${item.alias} { background-color: ${item.color}}`);

        $('#colorpicker-' + item.alias).spectrum({
            color: item.color,
            change: color => {
                const fields = document.querySelectorAll('#attendance-table tbody .' + item.alias);
                fields.forEach(field => {
                    field.style.backgroundColor = color.toHexString();
                });

                ajax('PUT', `/api/abos/${item.id}`, {
                    data: JSON.stringify({
                        color: color.toHexString()
                    })
                });
            },
            move: color => {
                const fields = document.querySelectorAll('#attendance-table tbody .' + item.alias);
                fields.forEach(field => {
                    field.style.backgroundColor = color.toHexString();
                });
            }
        });
    });
}
